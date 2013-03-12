<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

class Artist extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client                   $httpClient
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     * @param Guzzle\Http\QueryString              $queryString
     */
    function let($httpClient, $request, $response, $response, $queryString)
    {
        $request->getQuery()->willReturn($queryString);
        $request->send()->willReturn($response);

        $this->beConstructedWith($httpClient);
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
        $this->shouldThrow(new UnknownMethodException('Call to undefined method SevenDigital\Service\Artist::invalidMethod().'))->duringInvalidMethod('incredibru');
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
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->browse();
    }

    function its_browse_method_should_use_first_argument_as_the_letter_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $queryString->merge(array('letter' => 'b'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->browse('b');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/chart')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->chart();
    }

    function its_chart_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Artist::chart() has no default parameter.'))->duringChart('foo');
    }

    function its_details_method_should_create_a_GET_request_to_the_details_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details();
    }

    function its_details_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request);
        $queryString->merge(array('artistId' => 42))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details(42);
    }

    function its_releases_method_should_create_a_GET_request_to_the_releases_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->releases();
    }

    function its_releases_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request);
        $queryString->merge(array('artistId' => 123))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->releases(123);
    }

    function its_search_method_should_create_a_GET_request_to_the_search_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/search')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->search();
    }

    function its_search_method_should_use_first_argument_as_the_q_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/search')->willReturn($request);
        $queryString->merge(array('q' => 'Lenny Kravitz'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->search('Lenny Kravitz');
    }

    function its_toptracks_method_should_create_a_GET_request_to_the_toptracks_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/toptracks')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->toptracks();
    }

    function its_toptracks_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/toptracks')->willReturn($request);
        $queryString->merge(array('artistId' => 123))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->toptracks(123);
    }

    function its_similar_method_should_create_a_GET_request_to_the_similar_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/similar')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->similar();
    }

    function its_similar_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/similar')->willReturn($request);
        $queryString->merge(array('artistId' => 123))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->similar(123);
    }

    function its_tags_method_should_create_a_GET_request_to_the_tags_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/tags')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->tags();
    }

    function its_tags_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/tags')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Artist::tags() has no default parameter.'))->duringTags('foo');
    }

    function its_byTopTags_method_should_create_a_GET_request_to_the_bytag_top_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/bytag/top')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byTopTags();
    }

    function its_byTopTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/bytag/top')->willReturn($request);
        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byTopTags('rock, pop, 2000s');
    }
}
