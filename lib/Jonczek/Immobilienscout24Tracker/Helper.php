<?php

namespace Jonczek\Immobilienscout24Tracker;

class Helper
{
    private function __construct() { }

    public static function render($templateFile, $data)
    {
        ob_start();

        include($templateFile);
        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }
}
