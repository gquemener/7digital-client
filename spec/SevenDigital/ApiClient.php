<?php

namespace spec\SevenDigital;

use PHPSpec2\ObjectBehavior;

class ApiClient extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client              $httpClient
     * @param Guzzle\Plugin\Oauth\OauthPlugin $oauth
     */
    function let($httpClient, $oauth)
    {
        $httpClient->addSubscriber($oauth)->shouldBeCalled();

        $this->beConstructedWith($httpClient, $oauth);
    }

    function it_should_provide_access_to_the_track_service()
    {
        $service = $this->getTrackService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Track');
    }
}
