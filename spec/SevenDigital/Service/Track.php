<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;

class Track extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client           $httpClient
     * @param SevenDigital\ResponseFactory $responseFactory
     */
    function let($httpClient, $responseFactory)
    {
        $responseFactory->createFromXml(ANY_ARGUMENT)->willReturn(array());

        $this->beConstructedWith($httpClient, $responseFactory);
    }

    function it_should_be_an_api_service()
    {
        $this->shouldBeAnInstanceOf('SevenDigital\Service\AbstractService');
    }

    function it_should_be_named_track()
    {
        $this->getName()->shouldReturn('track');
    }

    /**
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     * @param Guzzle\Http\QueryString              $queryString
     */
    function it_should_send_a_tracks_search_according_to_specified_parameters(
        $httpClient, $responseFactory, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', '/track/search')->willReturn($request);
        $request->getQuery()->willReturn($queryString);
        $queryString->merge(array('q' => 'Genesis'))->shouldBeCalled();
        $request->send()->willReturn($response);
        $response->getStatusCode()->willReturn(200);

        $result = $this->search('Genesis');
        $result->shouldBe([]);
    }

    function it_should_throw_exception_for_undefined_method()
    {
        $this->shouldThrow(new \Exception('Call to undefined method SevenDigital\Service\Track::invalidMethod().'))->duringInvalidMethod('incredibru');
    }
}
