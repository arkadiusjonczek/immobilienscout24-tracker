<?php

namespace Jonczek\Immobilienscout24Tracker;

class EmailJob implements IJob
{
    public function execute(SearchResult $searchResult)
    {
        $body = Helper::render(
            Config::getEmailTemplate(),
            array('entries' => $searchResult->getNewEntries())
        );

        $mailSender = Config::getMailSender();
        $mailReceiver = Config::getMailReceiver();
        $mailHeader = 'From: ' . $mailSender . "\n" .
                      'Content-type: text/html; charset=utf-8' . "\r\n";
        $mailSubject = Config::getMailSubject();

        $sent = mail($mailReceiver, $mailSubject, $body, $mailHeader);

        if (!$sent)
        {
            throw new Exception('E-Mail to ' . $mailReceiver . 
                ' with title "' . $mailSubject . '" couldn\'t be sent.');
        }
    }
}
