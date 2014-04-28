<?php

namespace SevenDigital\Exception\Factory;

use SevenDigital\Exception\APIErrorException;

class APIErrorExceptionFactory extends AbstractExceptionFactory
{
    public function supports(\SimpleXMLElement $xml)
    {
        return '7' === $this->getErrorCodeCategory($xml);
    }

    protected function createException(\SimpleXMLElement $xml)
    {
        return new APIErrorException(
            $this->getErrorMessage($xml),
            (integer) $this->getErrorCode($xml)
        );
    }
}
