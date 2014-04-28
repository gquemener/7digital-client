<?php

namespace SevenDigital\Exception\Factory;

use SevenDigital\Exception\InvalidOrMissingInputParametersException;

class InvalidOrMissingInputParametersExceptionFactory extends AbstractExceptionFactory
{
    public function supports(\SimpleXMLElement $xml)
    {
        return '1' === $this->getErrorCodeCategory($xml);
    }

    protected function createException(\SimpleXMLElement $xml)
    {
        return new InvalidOrMissingInputParametersException(
            $this->getErrorMessage($xml),
            (integer) $this->getErrorCode($xml)
        );
    }
}
