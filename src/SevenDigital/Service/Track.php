<?php

namespace SevenDigital\Service;

class Track extends AbstractService
{
    public function getName()
    {
        return 'track';
    }

    public function configure()
    {
        $this->addMethod('search', 'GET', function ($params) {
            if (!isset($params[0]) || (is_array($params[0]) && !array_key_exists('q', $params[0]))) {
                throw new \Exception('You must provide at least a "q" parameter');
            }

            return is_array($params[0]) ? $params[0] : array('q' => $params[0]);
        });
    }
}
