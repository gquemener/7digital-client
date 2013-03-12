<?php

namespace SevenDigital;

use Guzzle\Http\Client;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;
use Doctrine\Common\Cache\ApcCache;
use SevenDigital\EventListener\AddConsumerKeySubscriber;
use SevenDigital\EventListener\ErrorToExceptionSubscriber;
use SevenDigital\Service;

class ApiClient
{
    protected $httpClient;

    public function __construct($consumerKey, $cache = false, $version = '1.2')
    {
        $this->httpClient = new Client('http://api.7digital.com/{version}', array(
            'version' => $version,
        ));

        if ($cache) {
            if (!$cache instanceof \Doctrine\Common\Cache\Cache) {
                throw new \Exception('Provided cache does not implement "Doctrine\Common\Cache\Cache"');
            }
            $adapter    = new DoctrineCacheAdapter($cache);
            $subscriber = new CachePlugin($adapter);
            $this->httpClient->addSubscriber($subscriber);
        }

        $this->httpClient->addSubscriber(new AddConsumerKeySubscriber($consumerKey));
        $this->httpClient->addSubscriber(new ErrorToExceptionSubscriber);
    }

    public function getTrackService()
    {
        return new Service\Track($this->httpClient);
    }

    public function getArtistService()
    {
        return new Service\Artist($this->httpClient);
    }

    public function getReleaseService()
    {
        return new Service\Release($this->httpClient);
    }

    public function getTagService()
    {
        return new Service\Tag($this->httpClient);
    }
}
