<?php

$simple_html_dom = __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

require_once $simple_html_dom;

// get the content from the given URL
function get_content($url)
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

    $content_length = strlen($content);

    global $config;
    if ($config['debug'] === true)
    {
        debug('url = ' . $url . ', length = ' . $content_length, 'Content Length');
    }

    // convert to UTF8 encoding
    // TODO: do not use constant strings
    $content = mb_convert_encoding($content, 'utf-8', 'iso-8859-15');

    return $content;
}

// get all entries from the HTML page
function get_entries($html)
{
    $base_url = 'http://www.immobilienscout24.de';

    // pattern for our url
    $expose_url_pattern = 'http://www.immobilienscout24.de/expose/{id}';
    
    // found entries
    $entries = array();
    
    if ($html)
    {
        $ul = $html->find('ul[id=resultListItems]', 0);
        if ($ul)
        {
            foreach ($ul->children() as $li)
            {
                $entry = array();
                
                if ($li->attr['class'] === 'is24-banner') continue;
                
                $id = (int) $li->attr['data-obid'];

                if ($id === 0) continue;

                $entry['id'] = $id;
                $entry['url'] = str_replace('{id}', $id, $expose_url_pattern);
                
                $img = $li->find('img[class=galleryElement shown]', 0);
                if ($img)
                {
                    $picture_url = array_key_exists('data-src', $img->attr) ? 
                        $img->attr['data-src'] : $img->attr['src'];

                    if (strpos($picture_url, 'http://') !== 0)
                    {
                        $picture_url = $base_url . $picture_url;
                    }

                    $entry['picture_url'] = $picture_url;
                }
                
                $span = $li->find('span[class=title]', 0);
                if ($span)
                {
                    $title = $span->find('a', 0)->innertext;

                    $entry['title'] = $title;
                }

                $span_address = $li->find('span[class=street]', 0);
                if ($span_address)
                {
                    $subtitle = $span_address->innertext;

                    $entry['subtitle'] = $subtitle;
                }

                $div_details = $li->find('div[class=resultlist_criteria]', 0);
                if ($div_details)
                {
                    $price = $div_details->children(0)->children(1)->innertext;
                    $area = $div_details->children(1)->children(1)->innertext;
                    $rooms = $div_details->children(2)->children(1)->innertext;
                    $rooms = substr($rooms, 0, strpos($rooms, '<'));

                    $entry['price'] = trim($price);
                    $entry['area'] = trim($area);
                    $entry['rooms'] = trim($rooms);
                }

                $entries["$id"] = $entry;
            }
        }
    }
    
    return $entries;
}

// render the given template
function render($template, $param)
{
   ob_start();
   include($template);
   $contents = ob_get_contents();
   ob_end_clean();

   return $contents;
}

// small debug function
function debug($var, $desc = '')
{
    $date = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');
    $line = $datetime . ': ' . 
            ($desc === '' ? '' : '(' . $desc . ') ')  .  
            (is_array($var) ? implode(', ', $var) : $var) . 
            "\r\n";
    
    $logs_directory = __DIR__ . DIRECTORY_SEPARATOR .  'logs';
    if (!file_exists($logs_directory))
    {
        mkdir($logs_directory);
    }

    // write into ./logs/{date}.log file
    file_put_contents(
        $logs_directory . DIRECTORY_SEPARATOR .  $date . '.log', 
        $line, 
        FILE_APPEND | LOCK_EX
    );
}

// small debug content function
function debug_content($filename, $content, $timestamp)
{
    $logs_directory = __DIR__ . DIRECTORY_SEPARATOR .  'logs';
    if (!file_exists($logs_directory))
    {
        mkdir($logs_directory);
    }

    $timestamp_directory = $logs_directory . DIRECTORY_SEPARATOR . $timestamp;
    if (!file_exists($timestamp_directory))
    {
        mkdir($timestamp_directory);
    }

    // write into ./logs/{timestamp}/{filename}.log file
    file_put_contents(
        $timestamp_directory . DIRECTORY_SEPARATOR .  $filename, 
        $content, 
        FILE_APPEND | LOCK_EX
    );
}