<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use SevenDigital\Exception\UnknownMethodException;

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

        $request = $this->httpClient->createRequest(
            $this->methods[$method]['httpMethod'],
            sprintf('%s/%s', $this->getName(), $this->methods[$method]['endpoint'] ?: $method)
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
        $response = $request->send();

        if (200 !== $response->getStatusCode()) {
            throw new \Exception($response->getReasonPhrase());
        }

        switch (true) {
            case $response->isContentType('xml'):
                return $response->xml();

            case $response->isContentType('audio'):
                $response->getBody()->getStream();

            default:
                return $response->getBody();
        }
    }
}
