<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;

class Artist extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client                   $httpClient
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     * @param Guzzle\Http\QueryString              $queryString
     */
    function let($httpClient, $request, $response, $queryString)
    {
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);

        $this->beConstructedWith($httpClient, 'consumer_key');
    }

    function it_should_be_an_api_service()
    {
        $this->shouldBeAnInstanceOf('SevenDigital\Service');
    }

    function it_should_be_named_artist()
    {
        $this->getName()->shouldReturn('artist');
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new \Exception('Call to undefined method SevenDigital\Service\Artist::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    function it_should_throw_an_exception_if_authorization_failed(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $response->getStatusCode()->willReturn(401);
        $response->getReasonPhrase()->willReturn('Authentication failed');

        $this->shouldThrow(new \Exception('Authentication failed'))->duringBrowse('P');
    }

    function its_browse_method_should_throw_exception_if_no_argument_has_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "letter" parameter'))->duringBrowse();
    }

    function its_browse_method_should_throw_exception_if_the_letter_has_not_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "letter" parameter'))->duringBrowse(array('pageSize' => 10));
    }

    function its_browse_method_should_use_a_scalar_argument_as_the_query_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('letter' => 'b'))->shouldBeCalled();

        $result = $this->browse('b');
        $result->shouldBe(array());
    }

    function its_browse_method_should_use_an_array_argument_as_the_7digital_query_string(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('letter' => 'c', 'pageSize' => 5))->shouldBeCalled();

        $this->browse(array('letter' => 'c', 'pageSize' => 5));
    }
}
