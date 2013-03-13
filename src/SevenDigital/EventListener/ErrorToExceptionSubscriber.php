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
        if (false === $response->isContentType('xml')) {
            return;
        }

        $xml = $response->xml();
        if ($this->hasError($xml)) {
            switch ($this->getErrorCodeCategory($xml)) {
                case '1':
                    throw new InvalidOrMissingInputParametersException($this->getErrorMessage($xml), $this->getErrorCode($xml));
                case '2':
                    throw new InvalidResourceReferenceException($this->getErrorMessage($xml), $this->getErrorCode($xml));
                case '3':
                    throw new UserCardErrorException($this->getErrorMessage($xml), $this->getErrorCode($xml));
                case '7':
                    throw new APIErrorException($this->getErrorMessage($xml), $this->getErrorCode($xml));
                case '9':
                    throw new InternalServerErrorException($this->getErrorMessage($xml), $this->getErrorCode($xml));
            }
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
