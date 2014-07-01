<?php

namespace Jonczek\Immobilienscout24Tracker;

class Tracker
{
    private $searchCriteria;

    private $jobs = array();

    public function __construct(SearchCriteria $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function addJob(IJob $job)
    {
        $this->jobs[] = $job;
    }

    public function run()
    {
        $search = new Search($this->searchCriteria);
        $searchResult = $search->run();

        foreach ($this->jobs as $job)
        {
            $job->execute($searchResult);
        }
    }
}
