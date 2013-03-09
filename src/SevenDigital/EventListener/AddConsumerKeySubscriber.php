<?php

namespace SevenDigital\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;

class AddConsumerKeySubscriber implements EventSubscriberInterface
{
    private $consumerKey;

    public function __construct($consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    public function onRequestBeforeSend(Event $event)
    {
        $event['request']->getQuery()->merge(array(
            'oauth_consumer_key' => $this->consumerKey
        ));
    }
}
