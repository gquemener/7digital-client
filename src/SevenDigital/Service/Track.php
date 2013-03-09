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
        $this->addMethod('search', 'GET', array(
            'q',
        ));
    }
}
