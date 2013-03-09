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
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);

        $this->beConstructedWith($httpClient, 'consumer_key');
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

    function its_search_method_should_throw_exception_if_no_argument_has_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "q" parameter'))->duringSearch();
    }

    function its_search_method_should_throw_exception_if_the_query_has_not_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "q" parameter'))->duringSearch(array('pageSize' => 10));
    }

    function its_search_method_should_use_a_scalar_argument_as_the_query_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('q' => 'Genesis'))->shouldBeCalled();

        $result = $this->search('Genesis');
        $result->shouldBe(array());
    }

    function its_search_method_should_use_an_array_argument_as_the_7digital_query_string(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('q' => 'Genesis', 'pageSize' => 5))->shouldBeCalled();

        $this->search(array('q' => 'Genesis', 'pageSize' => 5));
    }

    function its_chart_method_should_fetch_7digital_chart(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(null)->shouldBeCalled();

        $this->chart()->shouldReturn(array());
    }

    function its_chart_method_should_not_pass_given_arguments_to_the_request(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(null)->shouldBeCalled();

        $this->chart(array('foo' => 'bar'))->shouldReturn(array());
    }

    function its_details_method_should_throw_exception_if_no_argument_has_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "trackId" parameter'))->duringDetails();
    }

    function its_details_method_should_throw_exception_if_the_trackId_has_not_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "trackId" parameter'))->duringDetails(array('pageSize' => 10));
    }

    function its_details_method_should_use_a_scalar_argument_as_the_query_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('trackId' => 123))->shouldBeCalled();

        $result = $this->details(123);
        $result->shouldBe(array());
    }

    function its_details_method_should_use_an_array_argument_as_the_7digital_query_string(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('trackId' => 456))->shouldBeCalled();

        $this->details(array('trackId' => 456));
    }

    function its_preview_method_should_throw_exception_if_no_argument_has_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "trackId" parameter'))->duringPreview();
    }

    function its_preview_method_should_throw_exception_if_the_trackId_has_not_been_set(
        $httpClient, $request
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request);

        $this->shouldThrow(new \Exception('You must provide at least a "trackId" parameter'))->duringPreview();
    }

    function its_preview_method_should_never_redirect(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('trackId' => 123, 'redirect' => 'false'))->shouldBeCalled();

        $result = $this->preview(123);
        $result->shouldBe(array());
    }

    function its_preview_method_should_use_an_array_argument_as_the_7digital_query_string(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'track/preview')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->xml()->willReturn(array());

        $queryString->merge(array('trackId' => 456, 'redirect' => 'false'))->shouldBeCalled();

        $this->preview(array('trackId' => 456, 'redirect' => true));
    }
}
