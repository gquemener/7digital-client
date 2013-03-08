<?php

namespace SevenDigital\Model;

class Track
{
    protected $id;
    protected $title;
    protected $version;
    protected $artist;
    protected $trackNumber;
    protected $duration;
    protected $explicitContent;
    protected $isrc;
    protected $type;
    protected $release;
    protected $url;
    protected $image;
    protected $price;
    protected $streamingReleaseDate;
    protected $discNumber;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setTrackNumber($trackNumber)
    {
        $this->trackNumber = $trackNumber;
    }

    public function getTrackNumber()
    {
        return $this->trackNumber;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setExplicitContent($explicitContent)
    {
        $this->explicitContent = $explicitContent;
    }

    public function getExplicitContent()
    {
        return $this->explicitContent;
    }

    public function setIsrc($isrc)
    {
        $this->isrc = $isrc;
    }

    public function getIsrc()
    {
        return $this->isrc;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setRelease(Release $release)
    {
        $this->release = $release;
    }

    public function getRelease()
    {
        return $this->release;
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

    public function setPrice(Price $price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setStreamingReleaseDate(\DateTime $streamingReleaseDate)
    {
        $this->streamingReleaseDate = $streamingReleaseDate;
    }

    public function getStreamingReleaseDate()
    {
        return $this->streamingReleaseDate;
    }

    public function setDiscNumber($discNumber)
    {
        $this->discNumber = $discNumber;
    }

    public function getDiscNumber()
    {
        return $this->discNumber;
    }

}
