<?php

namespace spec\SevenDigital\Service;

use PhpSpec\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

class ArtistSpec extends ObjectBehavior
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

    function it_should_be_named_artist()
    {
        $this->getName()->shouldReturn('artist');
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new UnknownMethodException('Call to undefined method SevenDigital\Service\Artist::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    function its_browse_method_should_create_a_GET_request_to_the_browse_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->browse()->shouldReturn('<response>');
    }

    function its_browse_method_should_use_first_argument_as_the_letter_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/browse')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('letter' => 'b'))->shouldBeCalled();

        $this->browse('b')->shouldReturn('<response>');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->chart()->shouldReturn('<response>');
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
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->details()->shouldReturn('<response>');;
    }

    function its_details_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('artistId' => 42))->shouldBeCalled();

        $this->details(42)->shouldReturn('<response>');
    }

    function its_releases_method_should_create_a_GET_request_to_the_releases_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->releases()->shouldReturn('<response>');
    }

    function its_releases_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/releases')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('artistId' => 123))->shouldBeCalled();

        $this->releases(123)->shouldReturn('<response>');
    }

    function its_search_method_should_create_a_GET_request_to_the_search_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->search()->shouldReturn('<response>');
    }

    function its_search_method_should_use_first_argument_as_the_q_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('q' => 'Lenny Kravitz'))->shouldBeCalled();

        $this->search('Lenny Kravitz')->shouldReturn('<response>');
    }

    function its_toptracks_method_should_create_a_GET_request_to_the_toptracks_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/toptracks')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->toptracks()->shouldReturn('<response>');
    }

    function its_toptracks_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/toptracks')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('artistId' => 123))->shouldBeCalled();

        $this->toptracks(123)->shouldReturn('<response>');
    }

    function its_similar_method_should_create_a_GET_request_to_the_similar_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/similar')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->similar()->shouldReturn('<response>');
    }

    function its_similar_method_should_use_first_argument_as_the_artist_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/similar')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('artistId' => 123))->shouldBeCalled();

        $this->similar(123)->shouldReturn('<response>');
    }

    function its_tags_method_should_create_a_GET_request_to_the_tags_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'artist/tags')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->tags()->shouldReturn('<response>');
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
        $httpClient->createRequest('GET', 'artist/bytag/top')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->byTopTags()->shouldReturn('<response>');
    }

    function its_byTopTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'artist/bytag/top')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();

        $this->byTopTags('rock, pop, 2000s')->shouldReturn('<response>');
    }
}
