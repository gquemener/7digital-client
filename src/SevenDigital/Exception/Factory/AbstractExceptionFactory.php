<?php

namespace SevenDigital\Exception\Factory;

abstract class AbstractExceptionFactory implements ExceptionFactoryInterface
{
    public function create(\SimpleXMLElement $xml)
    {
        if (!$this->isValid($xml)) {
            throw new \InvalidArgumentException('XML is not a valid errored 7digital response');
        }

        return $this->createException($xml);
    }

    abstract protected function createException(\SimpleXMLElement $xml);

    protected function getErrorCodeCategory(\SimpleXMLElement $xml)
    {
        $code = $this->getErrorCode($xml);

        return strlen($code) > 0 ? $code[0] : '';
    }

    protected function getErrorMessage(\SimpleXMLElement $xml)
    {
        return (string) $xml->error->errorMessage;
    }

    protected function getErrorCode(\SimpleXMLElement $xml)
    {
        return (string) $xml->error['code'];
    }

    protected function isValid(\SimpleXMLElement $xml)
    {
        return isset($xml['status']) && 'error' === (string) $xml['status'];
    }
}
