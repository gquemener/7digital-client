<?php

namespace SevenDigital\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;
use SevenDigital\Exception\InvalidOrMissingInputParametersException;
use SevenDigital\Exception\InvalidResourceReferenceException;
use SevenDigital\Exception\UserCardErrorException;
use SevenDigital\Exception\APIErrorException;
use SevenDigital\Exception\InternalServerErrorException;

class ErrorToExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'request.success' => 'onRequestSuccess'
        );
    }

    public function onRequestSuccess(Event $event)
    {
        $response = $event['response'];
        if (false === $response->isContentType('xml') || !$this->hasError($response->xml())) {
            return;
        }

        switch ($this->getErrorCodeCategory($response->xml())) {
            case '1':
                throw new InvalidOrMissingInputParametersException(
                    $this->getErrorMessage($response->xml()),
                    (integer) $this->getErrorCode($response->xml())
                );
            case '2':
                throw new InvalidResourceReferenceException(
                    $this->getErrorMessage($response->xml()),
                    (integer) $this->getErrorCode($response->xml())
                );
            case '3':
                throw new UserCardErrorException(
                    $this->getErrorMessage($response->xml()),
                    (integer) $this->getErrorCode($response->xml())
                );
            case '7':
                throw new APIErrorException(
                    $this->getErrorMessage($response->xml()),
                    (integer) $this->getErrorCode($response->xml())
                );
            case '9':
                throw new InternalServerErrorException(
                    $this->getErrorMessage($response->xml()),
                    (integer) $this->getErrorCode($response->xml())
                );
        }
    }

    private function hasError(\SimpleXMLElement $xml)
    {
        return 'ok' !== (string) $xml['status'];
    }

    private function getErrorCodeCategory(\SimpleXMLElement $xml)
    {
        $code = $this->getErrorCode($xml);

        return strlen($code) > 0 ? $code[0] : '';
    }

    private function getErrorMessage(\SimpleXMLElement $xml)
    {
        return (string) $xml->error->errorMessage;
    }

    private function getErrorCode(\SimpleXMLElement $xml)
    {
        return (string) $xml->error['code'];
    }
}
