<?php

namespace spec\SevenDigital\Exception\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidResourceReferenceExceptionFactorySpec extends ObjectBehavior
{
    function it_is_an_exception_factory()
    {
        $this->shouldHaveType('SevenDigital\Exception\Factory\ExceptionFactoryInterface');
    }

    function it_supports_error_code_starting_by_2()
    {
        $xml = new \SimpleXMLElement(
            <<<XML
                <response status="error" version="1.2">
                    <error code="2001">
                      <errorMessage>Resource cannot be found</errorMessage>
                    </error>
                </response>
XML
        );

        $this->supports($xml)->shouldBe(true);
    }

    function it_creates_invalid_resource_reference_exception()
    {
        $xml = new \SimpleXMLElement(
            <<<XML
                <response status="error" version="1.2">
                    <error code="2001">
                      <errorMessage>Resource cannot be found</errorMessage>
                    </error>
                </response>
XML
        );

        $exception = $this->create($xml);
        $exception->shouldBeAnInstanceOf('SevenDigital\Exception\InvalidResourceReferenceException');
        $exception->getMessage()->shouldReturn('Resource cannot be found');
        $exception->getCode()->shouldReturn(2001);
    }

    function it_throws_exception_when_trying_to_convert_a_non_errored_response()
    {
        $xml = new \SimpleXMLElement('<response />');

        $exception = new \InvalidArgumentException('XML is not a valid errored 7digital response');
        $this->shouldThrow($exception)->duringCreate($xml);
    }
}
