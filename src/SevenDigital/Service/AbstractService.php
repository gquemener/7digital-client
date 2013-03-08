<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use SevenDigital\DOMDocumentFactory;
use Symfony\Component\Config\Util\XmlUtils;

abstract class AbstractService
{
    const STATUS_OK    = 'ok';
    const STATUS_ERROR = 'error';

    private $httpClient;
    private $xmlFactory;

    public function __construct(Client $httpClient, DOMDocumentFactory $xmlFactory = null)
    {
        $this->httpClient = $httpClient;
        $this->xmlFactory = $xmlFactory ?: new DOMDocumentFactory;
    }

    protected function get($uri)
    {
        $request = $this->httpClient->get($uri);

        return $this->call($request);
    }

    private function call(RequestInterface $request)
    {
        $response = $request->send();

        switch ($response->getStatusCode()) {
            case 401:
                throw new AuthorizationFailedException($response->getReasonPhrase());

            default:
                $data = $this->xmlFactory->createFromXml($response->getBody(true));
        }

        if (false === $this->hasError($data)) {
            return XmlUtils::convertDomElementToArray($data);
        } else {
            throw new BadRequestHttpException($this->getError($data));
        }
    }

    private function hasError($xml)
    {
        $status = $xml->attributes->getNamedItem('status')->nodeValue;

        switch ($status) {
            case self::STATUS_OK:
                return false;

            case self::STATUS_ERROR:
            default:
                return true;
        }
    }

    private function getError($xml)
    {
        return $xml->error->errorMessage;
    }
}
