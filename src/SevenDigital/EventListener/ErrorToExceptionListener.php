<?php

namespace SevenDigital\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;
use SevenDigital\Exception\InvalidOrMissingInputParametersException;
use SevenDigital\Exception\InvalidResourceReferenceException;

class ErrorToExceptionListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'request.success' => 'onRequestSuccess'
        );
    }

    public function onRequestSuccess(Event $event)
    {
        $response = $event['response']->xml();

        if ($this->hasError($response)) {
            switch ($this->getErrorCodeCategory($response)) {
                case '1':
                    throw new InvalidOrMissingInputParametersException($this->getErrorMessage($response));
                case '2':
                    throw new InvalidResourceReferenceException($this->getErrorMessage($response));
            }
        }
    }

    private function hasError(\SimpleXMLElement $xml)
    {
        return 'ok' !== (string) $xml['status'];
    }

    private function getErrorCodeCategory(\SimpleXMLElement $xml)
    {
        $code = (string) $xml->error['code'];

        return strlen($code) > 0 ? $code[0] : '';
    }

    private function getErrorMessage(\SimpleXMLElement $xml)
    {
        return (string) $xml->error->errorMessage;
    }
}
