<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Exception\BadResponseException;
use SevenDigital\Exception\UnknownMethodException;
use SevenDigital\Exception\Exception;

abstract class Service
{
    private $httpClient;
    private $methods = array();

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->configure();
    }

    public function __call($method, $arguments)
    {
        if (!isset($this->methods[$method])) {
            throw new UnknownMethodException(sprintf(
                'Call to undefined method %s::%s().', get_class($this), $method
            ));
        }

        $endpoint = null !== $this->methods[$method]['endpoint'] ? $this->methods[$method]['endpoint'] : $method;
        $request = $this->httpClient->createRequest(
            $this->methods[$method]['httpMethod'],
            sprintf('%s/%s', $this->getName(), $endpoint)
        );

        $params = $this->buildParameters($method, $arguments);
        $request->getQuery()->merge($params);

        return $this->request($request);
    }

    abstract public function configure();
    abstract public function getName();

    protected function addMethod($name, $httpMethod = 'GET', $defaultParameter = null, $endpoint = null)
    {
        $this->methods[$name] = array(
            'httpMethod'       => $httpMethod,
            'defaultParameter' => $defaultParameter,
            'endpoint'         => $endpoint,
        );
    }

    private function buildParameters($method, $arguments)
    {
        $argument = array_key_exists(0, $arguments) ? $arguments[0] : array();

        if (is_array($argument)) {
            return $argument;
        }

        if (null === $defaultParameter = $this->methods[$method]['defaultParameter']) {
            throw new \InvalidArgumentException(sprintf(
                'Impossible to match "%s" to a parameter, because method %s::%s() has no default parameter.',
                $argument, get_class($this), $method
            ));
        }

        return array($defaultParameter => $argument);
    }

    private function request(RequestInterface $request)
    {
        try {
            $response = $request->send();
        } catch (BadResponseException $e) {
            throw new Exception(sprintf(
                '7digital API responded with an error %d.',
                $e->getResponse()->getStatusCode()
            ), 0, $e);
        }

        return $this->getContent($response);
    }

    private function getContent(Response $response)
    {
        if ($response->isContentType('xml')) {
            return $response->xml();
        } else if ($response->isContentType('audio')) {
            return $response->getBody()->getStream();
        } else {
            return $response->getBody();
        }
    }
}
