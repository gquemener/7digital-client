<?php

namespace spec\SevenDigital\EventListener;

use PhpSpec\ObjectBehavior;
use SevenDigital\Exception\InvalidOrMissingInputParametersException;
use SevenDigital\Exception\InvalidResourceReferenceException;
use SevenDigital\Exception\UserCardErrorException;
use SevenDigital\Exception\InternalServerErrorException;
use SevenDigital\Exception\APIErrorException;
use SevenDigital\Exception\Factory\ExceptionFactoryInterface;

class ErrorToExceptionSubscriberSpec extends ObjectBehavior
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
    ) {
        $response->isContentType('xml')->willReturn(false);
        $response->xml()->shouldNotBeCalled();

        $this->onRequestSuccess($event);
    }

    function it_should_do_nothing_if_the_response_content_status_is_ok(
        $event, $response
    ) {
        $response->isContentType('xml')->willReturn(true);
        $response->xml()->willReturn(new \SimpleXMLElement(
<<<XML
            <response status="ok" version="1.2">
                <response_content />
            </response>
XML
        ));

        $this->onRequestSuccess($event);
    }

    function it_should_use_an_eligible_exception_factory_to_convert_error_into_exception(
        $event,
        $response,
        ExceptionFactoryInterface $factory
    ) {
        $this->registerFactory($factory);

        $response->isContentType('xml')->willReturn(true);
        $xml = new \SimpleXMLElement('<response />');
        $response->xml()->willReturn($xml);

        $factory->supports($xml)->willReturn(true);
        $exception = new \Exception();
        $factory->create($xml)->willReturn($exception);

        $this->shouldThrow($exception)->duringOnRequestSuccess($event);
    }
}
