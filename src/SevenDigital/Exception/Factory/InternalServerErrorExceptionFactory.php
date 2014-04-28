<?php

namespace SevenDigital\Exception\Factory;

use SevenDigital\Exception\InternalServerErrorException;

class InternalServerErrorExceptionFactory extends AbstractExceptionFactory
{
    public function supports(\SimpleXMLElement $xml)
    {
        return '9' === $this->getErrorCodeCategory($xml);
    }

    protected function createException(\SimpleXMLElement $xml)
    {
        return new InternalServerErrorException(
            $this->getErrorMessage($xml),
            (integer) $this->getErrorCode($xml)
        );
    }
}
