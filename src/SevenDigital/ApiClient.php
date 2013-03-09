<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use SevenDigital\Service;

class ApiClient
{
    protected $httpClient;
    protected $oauth;

    public function __construct(Client $httpClient, $consumerKey)
    {
        $this->httpClient  = $httpClient;
        $this->consumerKey = $consumerKey;
        //$this->httpClient->addSubscriber($oauth);
    }

    public function getTrackService()
    {
        return new Service\Track($this->httpClient, $this->consumerKey);
    }
}
