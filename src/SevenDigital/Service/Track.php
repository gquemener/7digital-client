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
        $this->addMethod('chart', 'GET', function ($params) { return null; });
        $this->addMethod('details', 'GET', function ($params) {
            if (!isset($params[0]) || (is_array($params[0]) && !array_key_exists('trackId', $params[0]))) {
                throw new \Exception('You must provide at least a "trackId" parameter');
            }

            return is_array($params[0]) ? $params[0] : array('trackId' => $params[0]);
        });
        $this->addMethod('preview', 'GET', function ($params) {
            if (!isset($params[0]) || (is_array($params[0]) && !array_key_exists('trackId', $params[0]))) {
                throw new \Exception('You must provide at least a "trackId" parameter');
            }

            $params = is_array($params[0]) ? $params[0] : array('trackId' => $params[0]);
            $params['redirect'] = 'false';

            return $params;
        });
    }
}
