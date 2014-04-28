<?php

namespace SevenDigital;

use Doctrine\Common\Cache\Cache;
use Guzzle\Http\Client;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;
use SevenDigital\EventListener\AddConsumerKeySubscriber;
use SevenDigital\EventListener\ErrorToExceptionSubscriber;
use SevenDigital\Exception\Factory;
use SevenDigital\Service;

class ApiClient
{
    protected $httpClient;

    public function __construct($consumerKey, $cache = null, $version = '1.2')
    {
        $this->httpClient = new Client(
            'http://api.7digital.com/{version}',
            array(
                'version' => $version,
            )
        );

        if ($cache) {
            if (!$cache instanceof Cache) {
                throw new \Exception('Provided cache does not implement "Doctrine\Common\Cache\Cache"');
            }
            $this->registerCachePlugin($cache);
        }

        $this->registerConsumerKeySubscriber($consumerKey);
        $this->registerExceptionFactories();
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

    private function registerCachePlugin(Cache $cache)
    {
        $this->httpClient->addSubscriber(
            new CachePlugin(
                new DoctrineCacheAdapter($cache)
            )
        );
    }

    private function registerConsumerKeySubscriber($consumerKey)
    {
        $this->httpClient->addSubscriber(
            new AddConsumerKeySubscriber(
                $consumerKey
            )
        );
    }

    private function registerExceptionFactories()
    {
        $subscriber = new ErrorToExceptionSubscriber();
        $subscriber->registerFactory(new Factory\InvalidOrMissingInputParametersExceptionFactory());
        $subscriber->registerFactory(new Factory\InvalidResourceReferenceExceptionFactory());
        $subscriber->registerFactory(new Factory\UserCardErrorExceptionFactory());
        $subscriber->registerFactory(new Factory\APIErrorExceptionFactory());
        $subscriber->registerFactory(new Factory\InternalServerErrorExceptionFactory());

        $this->httpClient->addSubscriber($subscriber);
    }
}
