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

    function its_browse_method_should_create_a_GET_request_to_the_browse_endpoint(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request)->shouldBeCalled();

        $this->browse();
    }

    function its_browse_method_should_use_first_argument_as_the_letter_parameter(
        $httpClient, $request, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $queryString->merge(array('letter' => 'b'))->shouldBeCalled();

        $this->browse('b');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/chart')->willReturn($request)->shouldBeCalled();

        $this->chart();
    }

    function its_chart_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/chart')->willReturn($request);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Artist::chart() has no default parameter.'))->duringChart('foo');
    }

    function its_details_method_should_create_a_GET_request_to_the_details_endpoint(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request)->shouldBeCalled();

        $this->details();
    }

    function its_details_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request);
        $queryString->merge(array('artistId' => 42))->shouldBeCalled();

        $this->details(42);
    }

    function its_releases_method_should_create_a_GET_request_to_the_releases_endpoint(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request)->shouldBeCalled();

        $this->releases();
    }

    function its_releases_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request);
        $queryString->merge(array('artistId' => 123))->shouldBeCalled();

        $this->releases(123);
    }
}
