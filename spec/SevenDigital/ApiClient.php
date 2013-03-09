<?php

namespace spec\SevenDigital;

use PHPSpec2\ObjectBehavior;

class ApiClient extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client $httpClient
     */
    function let($httpClient)
    {
        $this->beConstructedWith($httpClient, 'consumer_key');
    }

    function it_should_provide_access_to_the_track_service()
    {
        $service = $this->getTrackService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Track');
    }
}
