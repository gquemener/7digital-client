<?php

namespace spec\SevenDigital;

use PHPSpec2\ObjectBehavior;

class ApiClient extends ObjectBehavior
{
    function let($httpClient)
    {
        $this->beConstructedWith('consumer_key');
    }

    function it_should_provide_access_to_the_track_service()
    {
        $service = $this->getTrackService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Track');
    }

    function it_should_provide_access_to_the_artist_service()
    {
        $service = $this->getArtistService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Artist');
    }

    function it_should_provide_access_to_the_release_service()
    {
        $service = $this->getReleaseService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Release');
    }

    function it_should_provide_access_to_the_tag_service()
    {
        $service = $this->getTagService();
        $service->shouldBeAnInstanceOf('SevenDigital\Service\Tag');
    }
}
