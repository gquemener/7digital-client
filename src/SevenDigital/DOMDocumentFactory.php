<?php

namespace SevenDigital;

class DOMDocumentFactory
{
    public function createFromXml($xml)
    {
        return new \DOMDocument($xml);
    }
}
