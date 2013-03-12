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
        $this->addMethod('chart');
        $this->addMethod('details', 'GET', 'artistId');
        $this->addMethod('releases', 'GET', 'artistId');
        $this->addMethod('search', 'GET', 'q');
        $this->addMethod('toptracks', 'GET', 'artistId');
        $this->addMethod('similar', 'GET', 'artistId');
        $this->addMethod('tags');
        $this->addMethod('byTopTags', 'GET', 'tags', 'bytag/top');
    }
}
