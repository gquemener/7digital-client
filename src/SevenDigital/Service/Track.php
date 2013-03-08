<?php

namespace SevenDigital\Service;

class Track extends AbstractService
{
    private $endpoint = 'track';

    public function search($query)
    {
        return $this->get(sprintf('/%s/search?q=%s', $this->endpoint, $query));
    }
}
