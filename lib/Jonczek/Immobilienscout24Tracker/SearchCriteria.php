<?php

namespace Jonczek\Immobilienscout24Tracker;

class SearchCriteria
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

    public function __construct(SearchCriteriaBuilder $builder)
    {
        $this->urlPattern = $builder->getUrlPattern();
        $this->state = $builder->getState();
        $this->city = $builder->getCity();
        $this->districts = $builder->getDistricts();
        $this->minArea = $builder->getMinArea();
        $this->maxArea = $builder->getMaxArea();
        $this->minRooms = $builder->getMinRooms();
        $this->maxRooms = $builder->getMaxRooms();
        $this->minRent = $builder->getMinRent();
        $this->maxRent = $builder->getMaxRent();
    }

    public static function fromConfig()
    {
        $searchCriteria = SearchCriteria::createBuilder()
            ->withUrlPattern(Config::getSearchUrlPattern())
            ->withState(Config::getSearchState())
            ->withCity(Config::getSearchCity())
            ->withDistricts(Config::getSearchDistricts())
            ->withMinArea(Config::getSearchMinArea())
            ->withMaxArea(Config::getSearchMaxArea())
            ->withMinRooms(Config::getSearchMinRooms())
            ->withMaxRooms(Config::getSearchMaxRooms())
            ->withMinRent(Config::getSearchMinRent())
            ->withMaxRent(Config::getSearchMaxRent())
            ->build();

        return $searchCriteria;
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

    public function getUrl($page = 1)
    {
        $searchKeys = array(
            '{sorting}', 
            '{page}', 
            '{state}', 
            '{city}', 
            '{districts}',
            '{min_rooms}', 
            '{max_rooms}', 
            '{min_area}', 
            '{max_area}',
            '{min_rent}', 
            '{max_rent}'
        );

        $keyValues = array(
            Sorting::Newest,
            $page,
            $this->state,
            $this->city,
            implode('_', $this->districts),
            $this->minRooms,
            $this->maxRooms,
            $this->minArea,
            $this->maxArea,
            $this->minRent,
            $this->maxRent
        );

        $urlPattern = Config::getSearchUrlPattern();
        $url = str_replace($searchKeys, $keyValues, $urlPattern);

        return $url;
    }

    public static function createBuilder()
    {
        return new SearchCriteriaBuilder();
    }
}
