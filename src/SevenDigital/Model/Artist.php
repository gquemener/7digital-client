<?php

namespace SevenDigital\Model;

class Artist
{
    protected $id;
    protected $name;
    protected $sortName;
    protected $appearsAs;
    protected $url;
    protected $image;
    protected $popularity;
    protected $bio;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSortName($sortName)
    {
        $this->sortName = $sortName;
    }

    public function getSortName()
    {
        return $this->sortName;
    }

    public function setAppearsAs($appearsAs)
    {
        $this->appearsAs = $appearsAs;
    }

    public function getAppearsAs()
    {
        return $this->appearsAs;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    public function getPopularity()
    {
        return $this->popularity;
    }

    public function setBio(Bio $bio)
    {
        $this->bio = $bio;
    }

    public function getBio()
    {
        return $this->bio;
    }

}
