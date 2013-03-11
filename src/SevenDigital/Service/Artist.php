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
        $this->addMethod('browse', 'GET', 'letter');
        $this->addMethod('chart', 'GET');
        $this->addMethod('details', 'GET', 'artistId');
        $this->addMethod('releases', 'GET', 'artistId');
    }
}
