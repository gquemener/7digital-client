<?php

namespace SevenDigital\Service;

use SevenDigital\Service;

class Track extends Service
{
    public function getName()
    {
        return 'track';
    }

    public function configure()
    {
        $this->addMethod('search', 'GET', 'q');
        $this->addMethod('chart');
        $this->addMethod('details', 'GET', 'trackId');
        $this->addMethod('preview', 'GET', 'trackId');
    }
}
