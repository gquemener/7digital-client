<?php

namespace spec\SevenDigital\Service;

use PhpSpec\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

class ReleaseSpec extends ObjectBehavior
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

    function it_should_be_named_release()
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
        $httpClient->createRequest('GET', 'release/bydate')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->bydate()->shouldReturn('<response>');
    }

    function its_bydate_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bydate')->willReturn($request);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::bydate() has no default parameter.'))->duringBydate('foo');
    }

    function its_chart_method_should_create_a_GET_request_to_the_chart_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/chart')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->chart()->shouldReturn('<response>');
    }

    function its_chart_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/chart')->willReturn($request);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::chart() has no default parameter.'))->duringChart('foo');
    }

    function its_details_method_should_create_a_GET_request_to_the_details_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->details()->shouldReturn('<response>');
    }

    function its_details_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/details')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();

        $this->details(42)->shouldReturn('<response>');
    }

    function its_recommend_method_should_create_a_GET_request_to_the_recommend_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/recommend')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->recommend()->shouldReturn('<response>');
    }

    function its_recommend_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/recommend')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();

        $this->recommend(42)->shouldReturn('<response>');
    }

    function its_search_method_should_create_a_GET_request_to_the_search_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->search()->shouldReturn('<response>');
    }

    function its_search_method_should_use_first_argument_as_the_q_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/search')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('q' => 'Welcome to the monkey house'))->shouldBeCalled();

        $this->search('Welcome to the monkey house')->shouldReturn('<response>');
    }

    function its_tracks_method_should_create_a_GET_request_to_the_tracks_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/tracks')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->tracks()->shouldReturn('<response>');
    }

    function its_tracks_method_should_use_first_argument_as_the_release_id_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/tracks')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('releaseId' => 42))->shouldBeCalled();

        $this->tracks(42)->shouldReturn('<response>');
    }

    function its_tags_method_should_create_a_GET_request_to_the_tags_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/tags')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->tags()->shouldReturn('<response>');
    }

    function its_tags_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/tags')->willReturn($request);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Release::tags() has no default parameter.'))->duringTags('foo');
    }

    function its_byNewTags_method_should_create_a_GET_request_to_the_bytags_new_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/new')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->byNewTags()->shouldReturn('<response>');
    }

    function its_byNewTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/new')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();

        $this->byNewTags('rock, pop, 2000s')->shouldReturn('<response>');
    }

    function its_byTopTags_method_should_create_a_GET_request_to_the_bytag_top_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/top')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $this->byTopTags()->shouldReturn('<response>');
    }

    function its_byTopTags_method_should_use_first_argument_as_the_tags_parameter(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'release/bytag/top')->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn('<response>');

        $queryString->merge(array('tags' => 'rock, pop, 2000s'))->shouldBeCalled();

        $this->byTopTags('rock, pop, 2000s')->shouldReturn('<response>');
    }
}
