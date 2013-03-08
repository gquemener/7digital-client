<?php

namespace SevenDigital\Service;

use Guzzle\Http\Client;

class Track extends AbstractService
{
    private $endpoint = 'track';

    public function search($query)
    {
        $request = $this->get(sprintf('/%s/search?q=%s', $this->endpoint, $query));

        $response = $request->send();

        //@TODO parse the response
    }
}
