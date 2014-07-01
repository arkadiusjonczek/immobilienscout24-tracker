<?php

namespace Jonczek\Immobilienscout24Tracker;

class Expose
{
    private $id;
    private $url;
    private $title;
    private $subtitle;
    private $area;
    private $rooms;
    private $price;
    private $pictureUrl;
    private $new;
    private $changed;

    public function __construct(ExposeBuilder $builder)
    {
        $this->id = $builder->getId();
        $this->url = str_replace('{id}', $this->id, Config::getExposeUrlPattern());
        $this->title = $builder->getTitle();
        $this->subtitle = $builder->getSubtitle();
        $this->area = $builder->getArea();
        $this->rooms = $builder->getRooms();
        $this->price = $builder->getPrice();
        $this->pictureUrl = $builder->getPictureUrl();
        $this->new = $builder->isNew();
        $this->changed = $builder->isChanged();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    public function isNew()
    {
        return $this->new;
    }

    public function isChanged()
    {
        return $this->changed;
    }

    public function isEqual($expose)
    {
        $equal = $this->getId()         === $expose->getId()        &&
                 $this->getTitle()      === $expose->getTitle()     &&
                 $this->getSubtitle()   === $expose->getSubtitle()  &&
                 $this->getArea()       === $expose->getArea()      &&
                 $this->getRooms()      === $expose->getRooms()     &&
                 $this->getPrice()      === $expose->getPrice()     &&
                 $this->getPictureUrl() === $expose->getPictureUrl();

        return $equal;

    }

    public static function createBuilder($id)
    {
        return new ExposeBuilder($id);
    }
}
