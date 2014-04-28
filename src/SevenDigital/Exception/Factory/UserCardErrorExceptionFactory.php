<?php

namespace SevenDigital\Exception\Factory;

use SevenDigital\Exception\UserCardErrorException;

class UserCardErrorExceptionFactory extends AbstractExceptionFactory
{
    public function supports(\SimpleXMLElement $xml)
    {
        return '3' === $this->getErrorCodeCategory($xml);
    }

    protected function createException(\SimpleXMLElement $xml)
    {
        return new UserCardErrorException(
            $this->getErrorMessage($xml),
            (integer) $this->getErrorCode($xml)
        );
    }
}
