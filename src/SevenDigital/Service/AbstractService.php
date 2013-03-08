<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;

abstract class AbstractService
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    protected function get($uri)
    {
        return $this->httpClient->get($uri);
    }
}

