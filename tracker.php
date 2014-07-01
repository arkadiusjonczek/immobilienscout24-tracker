<?php

namespace Jonczek\Immobilienscout24Tracker;

error_reporting(E_ALL);
ini_set('display_errors', '1');

$configFile = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
if (!file_exists($configFile))
{
    die("Config file 'config.php' doesn't exist. Please use 'config.sample.php' to create one.\r\n");
}

require_once $configFile;

$autoloadFile = __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

require_once $autoloadFile;

// if user runs script using -console parameter
define('CONSOLE', count($argv) >= 2 && in_array('-console', $argv));

// if user runs script using -verbose parameter
define('VERBOSE', count($argv) >= 2 && in_array('-verbose', $argv));

try
{
    Config::load($config);

    $searchCriteria = SearchCriteria::fromConfig();
    $tracker = new Tracker($searchCriteria);

    // job is dependant from run mode
    $job = null;

    // not started on cli mode
    if (php_sapi_name() != 'cli')
    {
        $job = new WebRenderJob();
    }
    else
    {
        if (CONSOLE)
        {
            $job = new ConsoleRenderJob();
        }
        else
        {
            $job = new EmailJob();
        }
    }

    $tracker->addJob($job);
    $tracker->run();
}
catch (Exception $exception)
{
    echo $exception;
}
