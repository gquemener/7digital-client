<?php

namespace SevenDigital\Exception;

class AuthenticationException extends Exception
{
    public function __construct()
    {
        parent::__construct('Authorization failed. Please check your oauth configuration');
    }
}
