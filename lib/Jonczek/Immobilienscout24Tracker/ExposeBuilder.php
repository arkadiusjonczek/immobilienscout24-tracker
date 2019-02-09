<?php

namespace Jonczek\Immobilienscout24Tracker;

class ExposeBuilder
{
    private $id;
    private $title;
    private $subtitle;
    private $area;
    private $rooms;
    private $price;
    private $pictureUrl;
    private $new;
    private $changed;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function withTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function withSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function withArea($area)
    {
        $this->area = $area;

        return $this;
    }

    public function withRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function withPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function withPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    public function withNew($new)
    {
        $this->new = $new;

        return $this;
    }

    public function withChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    public function getId()
    {
        return $this->id;
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

    public function build()
    {
        $this->validate();

        return new Expose($this);
    }

    protected function validate()
    {

    }
}
