<?php

namespace spec\SevenDigital\Exception;

use PHPSpec2\ObjectBehavior;

class UnknownMethodException extends ObjectBehavior
{
    function it_should_be_an_exception()
    {
        $this->shouldBeAnInstanceOf('\Exception');
    }
}
