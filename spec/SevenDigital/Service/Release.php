<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

class Release extends ObjectBehavior
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
        $this->getName()->shouldReturn('release');
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new UnknownMethodException('Call to undefined method SevenDigital\Service\Release::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    function its_bydate_method_should_create_a_GET_request_to_the_bydate_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/bydate')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->bydate();
    }

    function its_bydate_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bydate')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::bydate() has no default parameter.'))->duringBydate('foo');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/chart')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->chart();
    }

    function its_chart_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::chart() has no default parameter.'))->duringChart('foo');
    }

    function its_details_method_should_create_a_GET_request_to_the_details_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/details')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details();
    }

    function its_details_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/details')->willReturn($request);
        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->details(42);
    }

    function its_recommend_method_should_create_a_GET_request_to_the_recommend_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/recommend')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->recommend();
    }

    function its_recommend_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/recommend')->willReturn($request);
        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->recommend(42);
    }

    function its_search_method_should_create_a_GET_request_to_the_search_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/search')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->search();
    }

    function its_search_method_should_use_first_argument_as_the_q_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/search')->willReturn($request);
        $queryString->merge(array('q' => 'Welcome to the monkey house'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->search('Welcome to the monkey house');
    }

    function its_tracks_method_should_create_a_GET_request_to_the_tracks_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/tracks')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->tracks();
    }

    function its_tracks_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/tracks')->willReturn($request);
        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->tracks(42);
    }

    function its_tags_method_should_create_a_GET_request_to_the_tags_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/tags')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->tags();
    }

    function its_tags_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/tags')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::tags() has no default parameter.'))->duringTags('foo');
    }

    function its_byNewTags_method_should_create_a_GET_request_to_the_bytags_new_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/new')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byNewTags();
    }

    function its_byNewTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/new')->willReturn($request);
        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byNewTags('rock, pop, 2000s');
    }

    function its_byTopTags_method_should_create_a_GET_request_to_the_bytag_top_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/top')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byTopTags();
    }

    function its_byTopTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/top')->willReturn($request);
        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->byTopTags('rock, pop, 2000s');
    }
}
