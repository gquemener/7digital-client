<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;

class Track
{
    protected $httpClient;

    private $endpoint = 'track';

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function search($query)
    {
        $request = $this->httpClient->get(sprintf(
            '/%s/search?q=%s',
            $this->endpoint,
            $query
        ));

        $request->send();
    }
}
