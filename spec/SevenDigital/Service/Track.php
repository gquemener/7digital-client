<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

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
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);

        $this->beConstructedWith($httpClient);
    }

    function it_should_be_an_api_service()
    {
        $this->shouldBeAnInstanceOf('SevenDigital\Service');
    }

    function it_should_be_named_track()
    {
        $this->getName()->shouldReturn('track');
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new UnknownMethodException('Call to undefined method SevenDigital\Service\Track::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    function it_should_throw_an_exception_if_authorization_failed(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $response->getStatusCode()->willReturn(401);

        $this->shouldThrow('SevenDigital\Exception\AuthenticationException')->duringSearch('The Prodigy');
    }

    function its_search_method_should_create_a_GET_request_to_the_search_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->search();
    }

    function its_search_method_should_use_first_argument_as_the_q_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $queryString->merge(array('q' => 'The Prodigy'))->shouldBeCalled();

        $this->search('The Prodigy');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'track/chart')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->chart();
    }

    function its_chart_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Track::chart() has no default parameter.'))->duringChart('foo');
    }

    function its_details_method_should_create_a_GET_request_to_the_details_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details();
    }

    function its_details_method_should_use_first_argument_as_the_track_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request);
        $queryString->merge(array('trackId' => 123))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details(123);
    }

    function its_preview_method_should_create_a_GET_request_to_the_preview_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->preview();
    }

    function its_preview_method_should_use_first_argument_as_the_track_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request);
        $queryString->merge(array('trackId' => 123))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->preview(123);
    }
}
