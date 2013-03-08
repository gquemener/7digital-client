<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use SevenDigital\ResponseFactory;

abstract class AbstractService
{
    private $httpClient;
    private $responseFactory;
    private $methods = [];

    public function __construct(Client $httpClient, ResponseFactory $responseFactory = null)
    {
        $this->httpClient = $httpClient;
        $this->responseFactory = $responseFactory ?: new ResponseFactory;

        $this->configure();
    }

    public function __call($method, $arguments)
    {
        if (!isset($this->methods[$method])) {
            throw new \Exception(sprintf(
                'Call to undefined method %s::%s().', get_class($this), $method
            ));
        }

        $request = $this->httpClient->createRequest(
            $this->methods[$method]['httpMethod'],
            sprintf('/%s/%s', $this->getName(), $method)
        );


        $request->getQuery()->merge(array_combine(
            $this->methods[$method]['params'], $arguments
        ));

        return $this->request($request);
    }

    abstract public function configure();
    abstract public function getName();

    protected function addMethod($name, $httpMethod, $params)
    {
        $this->methods[$name] = [
            'httpMethod' => $httpMethod,
            'params'     => $params,
        ];
    }

    private function request(RequestInterface $request)
    {
        $response = $request->send();

        switch ($response->getStatusCode()) {
            case 401:
                throw new AuthorizationFailedException($response->getReasonPhrase());

            default:
            return $this->responseFactory->createFromXml($response->getBody(true));
        }
    }
}
