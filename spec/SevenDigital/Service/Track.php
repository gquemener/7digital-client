<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;

class Track extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client                   $httpClient
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     * @param Guzzle\Http\QueryString              $queryString
     */
    function let($httpClient, $request, $response, $queryString)
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);

        $this->beConstructedWith($httpClient, 'consumer_key');
    }

    function it_should_be_an_api_service()
    {
        $this->shouldBeAnInstanceOf('SevenDigital\Service\AbstractService');
    }

    function it_should_be_named_track()
    {
        $this->getName()->shouldReturn('track');
    }

    function it_should_throw_exception_if_no_argument_has_been_set()
    {
        $this->shouldThrow(new \Exception('You must provide at least a "q" parameter'))->duringSearch();
    }

    function it_should_throw_exception_if_the_query_has_not_been_set()
    {
        $this->shouldThrow(new \Exception('You must provide at least a "q" parameter'))->duringSearch(array('pageSize' => 10));
    }

    function it_should_treat_non_array_argument_as_the_query(
        $response, $queryString
    )
    {
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('q' => 'Genesis'))->shouldBeCalled();

        $result = $this->search('Genesis');
        $result->shouldBe(array());
    }

    function it_should_provide_array_argument_as_is_to_the_request(
        $response, $queryString
    )
    {
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('q' => 'Genesis', 'pageSize' => 5))->shouldBeCalled();

        $this->search(array('q' => 'Genesis', 'pageSize' => 5));
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new \Exception('Call to undefined method SevenDigital\Service\Track::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    /**
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     * @param Guzzle\Http\QueryString              $queryString
     */
    function it_should_throw_an_exception_if_authorization_failed(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);
        $response->getStatusCode()->willReturn(401);
        $response->getReasonPhrase()->willReturn('Authentication failed');

        $this->shouldThrow(new \Exception('Authentication failed'))->duringSearch('The Prodigy');
    }
}
