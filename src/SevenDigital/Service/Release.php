<?php

namespace SevenDigital\Service;

use SevenDigital\Service;

class Release extends Service
{
    public function getName()
    {
        return 'release';
    }

    public function configure()
    {
        $this->addMethod('bydate');
        $this->addMethod('chart');
        $this->addMethod('details', 'GET', 'releaseId');
        $this->addMethod('recommend', 'GET', 'releaseId');
        $this->addMethod('search', 'GET', 'q');
        $this->addMethod('tracks', 'GET', 'releaseId');
        $this->addMethod('tags');
        $this->addMethod('byNewTags', 'GET', 'tags', 'bytag/new');
        $this->addMethod('byTopTags', 'GET', 'tags', 'bytag/top');
    }
}
