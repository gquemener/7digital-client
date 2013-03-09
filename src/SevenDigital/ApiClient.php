<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use SevenDigital\Service;

class ApiClient
{
    protected $httpClient;
    protected $consumerKey;

    public function __construct($consumerKey, $version = '1.2')
    {
        $this->httpClient = new Client('http://api.7digital.com/{version}', array(
            'version'          => $version,
            'redirect.disable' => true,
        ));
        $this->consumerKey = $consumerKey;
    }

    public function getTrackService()
    {
        return new Service\Track($this->httpClient, $this->consumerKey);
    }
}
