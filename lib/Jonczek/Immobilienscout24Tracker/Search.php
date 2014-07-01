<?php

namespace Jonczek\Immobilienscout24Tracker;

// use 3rd party simple_html_dom lib
require_once 'simple_html_dom.php';

class Search
{
    private $searchCriteria;

    public function __construct(SearchCriteria $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    private function getContent($url)
    {
        $content = '';
        
        if (function_exists('curl_version'))
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $content = curl_exec($curl);
            // $charset = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            curl_close($curl);
        }
        else if (file_get_contents(__FILE__) && ini_get('allow_url_fopen'))
        {
            $content = file_get_contents($url);
        }
        else
        {
            return FALSE;
        }

        // convert to UTF8 encoding
        // TODO: do not use constant strings
        $content = mb_convert_encoding($content, 'utf-8', 'iso-8859-15');

        return $content;
    }

    private function getPagesCount(\simple_html_dom $html)
    {
        if (!$html)
        {
            throw new InvalidArgumentException('Argument "html" is null.');
        }

        $pages = 1;

        $ul_pager = $html->find('ul[data-is24-qa=paging_pages]');

        // get page count only if paging element was found
        if ($ul_pager)
        {
            $pages = (int) $ul_pager[0]->last_child()->children(0)->innertext;

            if (VERBOSE)
            {
                echo 'Found ' . $pages . ' Pages' . "\r\n";
            }
        }

        return $pages;
    }

    private function getEntries(\simple_html_dom $html)
    {
        if (!$html)
        {
            throw new InvalidArgumentException('Argument "html" is null.');
        }

        $base_url = 'http://www.immobilienscout24.de';
        
        // found entries
        $foundEntries = array();
        
        $ul = $html->find('ul[id=resultListItems]', 0);
        if ($ul)
        {
            foreach ($ul->children() as $li)
            {
                if ($li->attr['class'] === 'is24-banner') continue;
                
                $id = (int) $li->attr['data-obid'];

                if ($id === 0 || in_array($id, Config::getSearchExclude()))
                    continue;

                $picture_url = '';
                $title = '';
                $subtitle = '';
                $price = '';
                $area = '';
                $rooms = '';

                $img = $li->find('img[class=galleryElement shown]', 0);
                if ($img)
                {
                    $picture_url = array_key_exists('data-src', $img->attr) ? 
                        $img->attr['data-src'] : $img->attr['src'];

                    if (strpos($picture_url, 'http://') !== 0)
                    {
                        $picture_url = $base_url . $picture_url;
                    }
                }
                
                $span_title = $li->find('span[class=title]', 0);
                if ($span_title)
                {
                    $title = $span_title->find('a', 0)->innertext;
                }
                else
                {
                    $div_title = $li->find('div[class=title]', 0);

                    if ($div_title)
                    {
                        $title = $div_title->find('a', 0)->innertext;
                    }
                }

                $span_address = $li->find('span[class=street]', 0);
                if ($span_address)
                {
                    $subtitle = $span_address->innertext;
                }

                $div_details = $li->find('div[class=resultlist_criteria]', 0);
                if ($div_details)
                {
                    $price = $div_details->children(0)->children(1)->innertext;
                    $area = $div_details->children(1)->children(1)->innertext;
                    $rooms = $div_details->children(2)->children(1)->innertext;

                    // remove inner html
                    $rooms = substr($rooms, 0, strpos($rooms, '<'));

                    $price = trim($price);
                    $area = trim($area);
                    $rooms = trim($rooms);
                }

                $foundEntry = Expose::createBuilder($id)
                    ->withTitle($title)
                    ->withSubtitle($subtitle)
                    ->withPrice($price)
                    ->withArea($area)
                    ->withRooms($rooms)
                    ->withPictureUrl($picture_url)
                    ->build();

                $foundEntries["$id"] = $foundEntry;
            }
        }
        
        return $foundEntries;
    }

    public function run()
    {
        // get real page count from html content after first request
        $pages = 1;

        // entries of all pages
        $entriesOfAllPages = array();

        // get all entries for the search criteria
        for ($page = 1; $page <= $pages; $page++)
        {
            $url = $this->searchCriteria->getUrl($page);

            // get html content of the given page
            $content = $this->getContent($url);

            // create simple_html_dom object from content string
            $html = str_get_html($content);

            // get entries of page and attach them
            $entriesOfPage = $this->getEntries($html);
            $entriesOfAllPages = $entriesOfAllPages + $entriesOfPage;

            if ($page === 1)
            {
                $pages = $this->getPagesCount($html);
            }

            unset($content);
            unset($html);
        }

        $store = new ExposeStore();
        $store->connect();

        $storedEntries = $store->getEntries();

        // we only need new and changes entries
        $newEntries = array();
        $changedEntries = array();

        // look for new and changed entries
        foreach ($entriesOfAllPages as $id => $entry)
        {
            if (array_key_exists($id, $storedEntries))
            {
                $storedEntry = $storedEntries["$id"];

                if (!$entry->isEqual($storedEntry))
                {
                    $changedEntries["$id"] = $entry;
                }
            }
            else
            {
                $newEntries["$id"] = $entry;
            }
        }

        $store->insertEntries($newEntries);
        $store->updateEntries($changedEntries);

        $searchResult = SearchResult::createBuilder()
            ->withSearchCriteria($this->searchCriteria)
            ->withPagesCount($pages)
            ->withFoundEntriesCount(count($entriesOfAllPages))
            ->withFoundEntries($entriesOfAllPages)
            ->withNewEntries($newEntries)
            ->withChangedEntries($changedEntries)
            ->build();

        return $searchResult;
    }
}
