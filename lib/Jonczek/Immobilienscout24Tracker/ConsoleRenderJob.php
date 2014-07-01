<?php

namespace Jonczek\Immobilienscout24Tracker;

class ConsoleRenderJob implements IJob
{
    public function execute(SearchResult $searchResult)
    {
        $body = Helper::render(
            Config::getConsoleTemplate(),
            array('entries' => $searchResult->getNewEntries())
        );

        echo $body;
    }
}
