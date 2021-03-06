<?php

namespace spec\SevenDigital\Exception\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InternalServerErrorExceptionFactorySpec extends ObjectBehavior
{
    function it_is_an_exception_factory()
    {
        $this->shouldHaveType('SevenDigital\Exception\Factory\ExceptionFactoryInterface');
    }

    function it_supports_error_code_starting_by_9()
    {
        $xml = new \SimpleXMLElement(
            <<<XML
                <response status="error" version="1.2">
                    <error code="9001">
                      <errorMessage>Unexpected internal server error</errorMessage>
                    </error>
                </response>
XML
        );

        $this->supports($xml)->shouldBe(true);
    }

    function it_creates_internal_server_error_exception()
    {
        $xml = new \SimpleXMLElement(
            <<<XML
                <response status="error" version="1.2">
                    <error code="9001">
                      <errorMessage>Unexpected internal server error</errorMessage>
                    </error>
                </response>
XML
        );

        $exception = $this->create($xml);
        $exception->shouldBeAnInstanceOf('SevenDigital\Exception\InternalServerErrorException');
        $exception->getMessage()->shouldReturn('Unexpected internal server error');
        $exception->getCode()->shouldReturn(9001);
    }

    function it_throws_exception_when_trying_to_convert_a_non_errored_response()
    {
        $xml = new \SimpleXMLElement('<response />');

        $exception = new \InvalidArgumentException('XML is not a valid errored 7digital response');
        $this->shouldThrow($exception)->duringCreate($xml);
    }
}
