<?php

namespace Jonczek\Immobilienscout24Tracker;

class SearchCriteriaBuilder
{
    private $urlPattern;
    private $state;
    private $city;
    private $districts;
    private $minArea;
    private $maxArea;
    private $minRooms;
    private $maxRooms;
    private $minRent;
    private $maxRent;

    public function __construct()
    {
        
    }

    public function withUrlPattern($urlPattern)
    {
        $this->urlPattern = $urlPattern;

        return $this;
    }

    public function withState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function withCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function withDistricts($districts)
    {
        $this->districts = $districts;

        return $this;
    }

    public function withMinArea($minArea)
    {
        $this->minArea = $minArea;

        return $this;
    }

    public function withMaxArea($maxArea)
    {
        $this->maxArea = $maxArea;

        return $this;
    }

    public function withMinRooms($minRooms)
    {
        $this->minRooms = $minRooms;

        return $this;
    }

    public function withMaxRooms($maxRooms)
    {
        $this->maxRooms = $maxRooms;

        return $this;
    }

    public function withMinRent($minRent)
    {
        $this->minRent = $minRent;

        return $this;
    }

    public function withMaxRent($maxRent)
    {
        $this->maxRent = $maxRent;

        return $this;
    }

    public function getUrlPattern()
    {
        return $this->urlPattern;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getDistricts()
    {
        return $this->districts;
    }

    public function getMinArea()
    {
        return $this->minArea;
    }

    public function getMaxArea()
    {
        return $this->maxArea;
    }

    public function getMinRooms()
    {
        return $this->minRooms;
    }

    public function getMaxRooms()
    {
        return $this->maxRooms;
    }

    public function getMinRent()
    {
        return $this->minRent;
    }

    public function getMaxRent()
    {
        return $this->maxRent;
    }

    public function build()
    {
        $this->validate();

        return new SearchCriteria($this);
    }

    protected function validate()
    {

    }
}
