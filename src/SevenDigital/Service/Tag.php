<?php

namespace SevenDigital\Service;

use SevenDigital\Service;

class Tag extends Service
{
    public function getName()
    {
        return 'tag';
    }

    public function configure()
    {
        $this->addMethod('list', 'GET', null, '');
    }
}
