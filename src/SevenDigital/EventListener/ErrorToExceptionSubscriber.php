<?php

namespace SevenDigital\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;
use SevenDigital\Exception\Factory\ExceptionFactoryInterface;

class ErrorToExceptionSubscriber implements EventSubscriberInterface
{
    protected $factories = array();

    public static function getSubscribedEvents()
    {
        return array(
            'request.success' => 'onRequestSuccess'
        );
    }

    public function registerFactory(ExceptionFactoryInterface $factory)
    {
        $this->factories[] = $factory;
    }

    public function onRequestSuccess(Event $event)
    {
        $response = $event['response'];
        if (false === $response->isContentType('xml') || !$this->hasError($response->xml())) {
            return;
        }

        foreach ($this->factories as $factory) {
            if ($factory->supports($response->xml())) {
                throw $factory->create($response->xml());
            }
        }
    }

    private function hasError(\SimpleXMLElement $xml)
    {
        return 'ok' !== (string) $xml['status'];
    }
}
