<?php

namespace Jonczek\Immobilienscout24Tracker;

class SearchResult
{
    private $searchCriteria;
    private $pagesCount;
    private $foundEntriesCount;
    private $foundEntries;
    private $newEntries;
    private $changedEntries;

    public function __construct(SearchResultBuilder $builder)
    {
        $this->searchCriteria = $builder->getSearchCriteria();
        $this->pagesCount = $builder->getPagesCount();
        $this->foundEntriesCount = $builder->getFoundEntriesCount();
        $this->foundEntries = $builder->getFoundEntries();
        $this->newEntries = $builder->getNewEntries();
        $this->changedEntries = $builder->getChangedEntries();
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    public function getPagesCount()
    {
        return $this->pagesCount;
    }

    public function getFoundEntriesCount()
    {
        return $this->foundEntriesCount;
    }

    public function getFoundEntries()
    {
        return $this->foundEntries;
    }

    public function getNewEntries()
    {
        return $this->newEntries;
    }

    public function getChangedEntries()
    {
        return $this->changedEntries;
    }

    public static function createBuilder()
    {
        return new SearchResultBuilder();
    }
}
