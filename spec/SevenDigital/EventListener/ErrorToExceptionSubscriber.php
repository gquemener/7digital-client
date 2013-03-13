<?php

namespace spec\SevenDigital\EventListener;

use PHPSpec2\ObjectBehavior;
use SevenDigital\Exception\InvalidOrMissingInputParametersException;
use SevenDigital\Exception\InvalidResourceReferenceException;
use SevenDigital\Exception\UserCardErrorException;
use SevenDigital\Exception\InternalServerErrorException;
use SevenDigital\Exception\APIErrorException;

class ErrorToExceptionSubscriber extends ObjectBehavior
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

    function it_should_do_nothing_if_the_response_content_type_is_not_xml(
        $event, $response
    )
    {
        $response->isContentType('xml')->willReturn(false);
        $response->xml()->shouldNotBeCalled();

        $this->onRequestSuccess($event);
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

    function it_should_throw_a_user_card_error_exception_when_error_code_starts_with_3(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="error" version="1.2">
                <error code="3001">
                  <errorMessage>The user's card has expired</errorMessage>
                </error>
            </response>
XML
        ));

        $this->shouldThrow(new UserCardErrorException('The user\'s card has expired', 3001))->duringOnRequestSuccess($event);
    }

    function it_should_throw_a_7digital_API_application_error_exception_when_error_code_starts_with_7(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="error" version="1.2">
                <error code="7001">
                  <errorMessage>Unable to perform action</errorMessage>
                </error>
            </response>
XML
        ));

        $this->shouldThrow(new APIErrorException('Unable to perform action', 7001))->duringOnRequestSuccess($event);
    }

    function it_should_throw_an_internal_server_error_exception_when_error_code_starts_with_9(
        $event, $response
    )
    {
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="error" version="1.2">
                <error code="9001">
                  <errorMessage>Unexpected internal server error</errorMessage>
                </error>
            </response>
XML
        ));

        $this->shouldThrow(new InternalServerErrorException('Unexpected internal server error', 9001))->duringOnRequestSuccess($event);
    }
}
