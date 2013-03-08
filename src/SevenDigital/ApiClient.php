<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class ApiClient
{
    public function __construct(Client $httpClient, OauthPlugin $oauth)
    {
        $this->httpClient = $httpClient;
        $this->httpClient->addSubscriber($oauth);
    }

    public function getTrackService()
    {
        return new Service\Track($this->httpClient);
    }
}
