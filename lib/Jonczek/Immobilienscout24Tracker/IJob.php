<?php

namespace Jonczek\Immobilienscout24Tracker;

interface IJob
{
    public function execute(SearchResult $searchResult);
}
