<?php

namespace Jonczek\Immobilienscout24Tracker;


class SearchResultBuilder
{
    private $searchCriteria;
    private $pagesCount;
    private $foundEntriesCount;
    private $foundEntries;
    private $newEntries;
    private $changedEntries;

    public function __construct()
    {

    }

    public function withSearchCriteria($searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;

        return $this;
    }

    public function withPagesCount($pagesCount)
    {
        $this->pagesCount = $pagesCount;

        return $this;
    }

    public function withFoundEntriesCount($foundEntriesCount)
    {
        $this->foundEntriesCount = $foundEntriesCount;

        return $this;
    }

    public function withFoundEntries($foundEntries)
    {
        $this->foundEntries = $foundEntries;

        return $this;
    }

    public function withNewEntries($newEntries)
    {
        $this->newEntries = $newEntries;

        return $this;
    }

    public function withChangedEntries($changedEntries)
    {
        $this->changedEntries = $changedEntries;

        return $this;
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

    public function build()
    {
        $this->validate();

        return new SearchResult($this);
    }

    protected function validate()
    {

    }
}
