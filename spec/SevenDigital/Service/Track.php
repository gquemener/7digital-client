<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;

class Track extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client $httpClient
     */
    function let($httpClient)
    {
        $this->beConstructedWith($httpClient);
    }

    /**
     * @param Guzzle\Http\Message\RequestInterface $request
     */
    function it_should_send_a_tracks_search_according_to_specified_parameters(
        $httpClient, $request
    )
    {
        $httpClient->get('/track/search?q=Genesis')->willReturn($request);
        $request->send()->shouldBeCalled();

        $this->search('Genesis');
    }
}
