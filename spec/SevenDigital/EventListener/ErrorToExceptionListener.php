<?php

namespace spec\SevenDigital\EventListener;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\InvalidOrMissingInputParametersException;
use SevenDigital\Exception\InvalidResourceReferenceException;

class ErrorToExceptionListener extends ObjectBehavior
{
    /**
     * @param Guzzle\Common\Event          $event
     * @param Guzzle\Http\Message\Response $response
     */
    function let($event, $response)
    {
        $event->offsetGet('response')->willReturn($response);
    }

    function it_should_be_an_event_subscriber()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_should_subscribe_to_request_success_event()
    {
        $this->getSubscribedEvents()->shouldReturn(array(
            'request.success' => 'onRequestSuccess'
        ));
    }

    function it_should_do_nothing_if_the_response_content_status_is_ok(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="ok" version="1.2">
                <response_content />
            </response>
XML
        ));

        $this->onRequestSuccess($event);
    }

    function it_should_throw_a_validation_exception_when_error_code_starts_with_1(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="error" version="1.2">
                <error code="1001">
                  <errorMessage>Missing artist ID</errorMessage>
                </error>
            </response>
XML
        ));

        $this->shouldThrow(new InvalidOrMissingInputParametersException('Missing artist ID', 1001))->duringOnRequestSuccess($event);
    }

    function it_should_throw_an_invalid_resource_exception_when_error_code_starts_with_2(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="error" version="1.2">
                <error code="2001">
                  <errorMessage>Resource cannot be found</errorMessage>
                </error>
            </response>
XML
        ));

        $this->shouldThrow(new InvalidResourceReferenceException('Resource cannot be found', 2001))->duringOnRequestSuccess($event);
    }
}
