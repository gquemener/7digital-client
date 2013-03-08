<?php

namespace SevenDigital\Model;

class Bio
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

}
