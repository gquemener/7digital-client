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
        $this->addMethod('chart', 'GET', function ($params) {
            if (!isset($params[0])) {
                return array();
            }

            if (!is_array($params[0])) {
                throw new \InvalidArgumentException('Argument must be provided as an array.');
            }

            if (isset($params[0]['period']) && !in_array($params[0]['period'], array('week', 'month', 'day'))) {
                throw new \InvalidArgumentException('Period parameter must be one of "week, month, day".');
            }

            if (isset($params[0]['toDate']) && $params[0]['toDate'] instanceof \DateTime) {
                $params[0]['toDate'] = $params[0]['toDate']->format('Ymd');
            }

            return $params[0];
        });
        $this->addMethod('details', 'GET', function ($params) {
            if (!isset($params[0]) || (is_array($params[0]) && !array_key_exists('artistId', $params[0]))) {
                throw new \InvalidArgumentException('You must provide at least an "artistId" parameter');
            }

            return is_array($params[0]) ? $params[0] : array('artistId' => $params[0]);
        });
    }
}
