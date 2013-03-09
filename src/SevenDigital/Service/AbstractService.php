<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use SevenDigital\EventListener\AddConsumerKeySubscriber;

abstract class AbstractService
{
    private $httpClient;
    private $responseFactory;
    private $methods = array();

    public function __construct(Client $httpClient, $consumerKey)
    {
        $this->httpClient      = $httpClient;
        $this->consumerKey     = $consumerKey;

        $this->configure();
    }

    public function __call($method, $arguments)
    {
        if (!isset($this->methods[$method])) {
            throw new \Exception(sprintf(
                'Call to undefined method %s::%s().', get_class($this), $method
            ));
        }

        $this->httpClient->addSubscriber(new AddConsumerKeySubscriber($this->consumerKey));

        $request = $this->httpClient->createRequest(
            $this->methods[$method]['httpMethod'],
            sprintf('%s/%s', $this->getName(), $method)
        );

        $request->getQuery()->merge(
            $this->methods[$method]['getParameters']($arguments)
        );

        return $this->request($request);
    }

    abstract public function configure();
    abstract public function getName();

    protected function addMethod($name, $httpMethod, \Closure $getParameters = null)
    {
        if (null === $getParameters) {
            $getParameters = function ($params) { return $params; };
        }

        $this->methods[$name] = array(
            'httpMethod'    => $httpMethod,
            'getParameters' => $getParameters,
        );
    }

    private function request(RequestInterface $request)
    {
        $response = $request->send();

        switch ($response->getStatusCode()) {
            case 401:
                throw new \Exception($response->getReasonPhrase());

            default:
                return $response->xml();
        }
    }
}
