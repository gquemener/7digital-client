<?php

namespace spec\SevenDigital\EventListener;

use PHPSpec2\ObjectBehavior;

class AddConsumerKeySubscriber extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('abcd1234');
    }

    function it_should_be_an_event_subscriber()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_should_subscribe_to_request_before_send_event()
    {
        $this->getSubscribedEvents()->shouldReturn(array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        ));
    }

    /**
     * @param Guzzle\Common\Event $event
     * @param Guzzle\Http\Message\RequestInterface $request
     * @param Guzzle\Http\QueryString $queryString
     */
    function it_should_add_the_configured_oauth_consumer_key_to_the_query_string(
        $event, $request, $queryString
    )
    {
        $event->offsetGet('request')->willReturn($request);
        $request->getQuery()->willReturn($queryString);
        $queryString->merge(array('oauth_consumer_key' => 'abcd1234'))->shouldBeCalled();

        $this->onRequestBeforeSend($event);
    }
}
