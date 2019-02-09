<?php

namespace Jonczek\Immobilienscout24Tracker;

class WebRenderJob implements IJob
{
    public function execute(SearchResult $searchResult)
    {
        $body = Helper::render(
            Config::getEmailTemplate(),
            array('entries' => $searchResult->getNewEntries())
        );

        header('Content-Type: text/html; charset=utf-8');
        echo $body;
    }
}
