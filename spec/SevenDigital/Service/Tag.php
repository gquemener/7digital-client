<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\UnknownMethodException;

class Tag extends ObjectBehavior
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

    function it_should_be_named_tag()
    {
        $this->getName()->shouldReturn('tag');
    }

    function it_should_throw_an_exception_for_undefined_method()
    {
        $this->shouldThrow(new UnknownMethodException('Call to undefined method SevenDigital\Service\Tag::invalidMethod().'))->duringInvalidMethod('incredibru');
    }

    function its_list_method_should_create_a_GET_request_to_the_list_endpoint(
        $httpClient, $request, $response
    )
    {
        $httpClient->createRequest('GET', 'tag/')->willReturn($request)->shouldBeCalled();
        $response->getStatusCode()->willReturn(200);

        $this->list();
    }

    function its_list_method_should_throw_exception_when_given_parameter_is_not_an_array(
        $httpClient, $request, $response, $queryString
    )
    {
        $httpClient->createRequest('GET', 'tag/')->willReturn($request);
        $response->getStatusCode()->willReturn(200);

        $this->shouldThrow(new \InvalidArgumentException('Impossible to match "foo" to a parameter, because method SevenDigital\Service\Tag::list() has no default parameter.'))->duringList('foo');
    }
}
