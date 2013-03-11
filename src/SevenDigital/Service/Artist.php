<?php

namespace SevenDigital\Service;

use SevenDigital\Service;

class Artist extends Service
{
    public function getName()
    {
        return 'artist';
    }

    public function configure()
    {
        $this->addMethod('browse', 'GET', function ($params) {
            if (!isset($params[0]) || (is_array($params[0]) && !array_key_exists('letter', $params[0]))) {
                throw new \InvalidArgumentException('You must provide at least a "letter" parameter');
            }

            return is_array($params[0]) ? $params[0] : array('letter' => $params[0]);
        });
    }
}
