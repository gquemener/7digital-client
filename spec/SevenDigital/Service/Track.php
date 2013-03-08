<?php

namespace spec\SevenDigital\Service;

use PHPSpec2\ObjectBehavior;

class Track extends ObjectBehavior
{
    /**
     * @param Guzzle\Http\Client              $httpClient
     * @param SevenDigital\DOMDocumentFactory $xmlFactory
     * @param stdClass                        $xml
     * @param stdClass                        $attributes
     * @param stdClass                        $statusNode
     */
    function let($httpClient, $xmlFactory, $xml, $attributes, $statusNode)
    {
        $xmlFactory->createFromXml(ANY_ARGUMENT)->willReturn($xml);
        $xml->attributes = $attributes;
        $attributes->getNamedItem('status')->willReturn($statusNode);

        $this->beConstructedWith($httpClient, $xmlFactory);
    }

    function it_should_be_an_api_service()
    {
        $this->shouldBeAnInstanceOf('SevenDigital\Service\AbstractService');
    }

    /**
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\Message\Response         $response
     */
    function it_should_send_a_tracks_search_according_to_specified_parameters(
        $httpClient, $xmlFactory, $request, $response, $statusNode
    )
    {
        $httpClient->get('/track/search?q=Genesis')->willReturn($request);
        $request->send()->shouldBeCalled()->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $statusNode->nodeValue = $this->STATUS_OK;

        $this->search('Genesis');
    }
}
