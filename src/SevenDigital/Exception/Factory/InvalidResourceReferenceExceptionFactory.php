<?php

namespace SevenDigital\Exception\Factory;

use SevenDigital\Exception\InvalidResourceReferenceException;

class InvalidResourceReferenceExceptionFactory extends AbstractExceptionFactory
{
    public function supports(\SimpleXMLElement $xml)
    {
        return '2' === $this->getErrorCodeCategory($xml);
    }

    protected function createException(\SimpleXMLElement $xml)
    {
        return new InvalidResourceReferenceException(
            $this->getErrorMessage($xml),
            (integer) $this->getErrorCode($xml)
        );
    }
}
