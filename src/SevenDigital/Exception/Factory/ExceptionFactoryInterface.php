<?php

namespace SevenDigital\Exception\Factory;

interface ExceptionFactoryInterface
{
    public function supports(\SimpleXMLElement $xml);
    public function create(\SimpleXMLElement $xml);
}
