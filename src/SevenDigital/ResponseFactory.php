<?php

namespace SevenDigital;

use Symfony\Component\Config\Util\XmlUtils;

class ResponseFactory
{
    public function createFromXml($xml)
    {
        $data = new \DOMDocument($xml);

        return XmlUtils::convertDomElementToArray($data->documentElement);
    }
}
