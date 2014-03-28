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
    
    // convert to utf-8 encoding
    // TODO: do not use constant strings
    $content = mb_convert_encoding($content, 'utf-8', 'iso-8859-15');

    return $content;
}

// get all entries from the HTML page
function get_entries($html)
{
    $base_url = "http://www.immobilienscout24.de";
    $expose_url_pattern = "http://www.immobilienscout24.de/expose/{0}";
    
    // found entries
    $entries = array();
    
    $ul = $html->find('ul[id=resultListItems]')[0];
    foreach ($ul->children() as $li)
    {
        $entry = array();
        
        if ($li->attr['class'] === 'is24-banner') continue;
        
        $id = (int) $li->attr['data-obid'];
        
        $a = $li->find('a[class=preview box]')[0];
        $picture_url = array_key_exists('data-src', $a->children(0)->attr) ? $a->children(0)->attr['data-src'] : $base_url . $a->children(0)->attr['src'];
        
        $h3 = $li->find('h3[class=medialist__heading mvn prm]')[0];
        $title = $h3->find('a')[0]->innertext;
        
        $div = $li->find('div[class=medialist__address_shown]')[0];
        $subtitle = $div->innertext;
        
        $div2 = $li->find('div[class=line medialist__criteria hideable]')[0];
        $price = $div2->children(0)->children(1)->innertext;
        $area = $div2->children(1)->children(1)->innertext;
        $rooms = $div2->children(2)->children(1)->innertext;
        
        $entry['id'] = $id;
        $entry['title'] = $title;
        $entry['subtitle'] = $subtitle;
        $entry['price'] = $price;
        $entry['area'] = $area;
        $entry['rooms'] = $rooms;
        $entry['url'] = str_replace('{0}', $id, $expose_url_pattern);
        $entry['picture_url'] = $picture_url;
        $entries["$id"] = $entry;
    }
    
    unset($html);
    
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