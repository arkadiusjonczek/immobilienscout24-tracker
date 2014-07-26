<?php

namespace Jonczek\Immobilienscout24Tracker;

class Config
{
    private static $instance;

    private $debug;
    private $searchIncludeNew;
    private $searchIncludeChanged;
    private $searchExclude;
    private $searchState;
    private $searchCity;
    private $searchDistricts;
    private $searchMinArea;
    private $searchMaxArea;
    private $searchMinRooms;
    private $searchMaxRooms;
    private $searchMinRent;
    private $searchMaxRent;
    private $searchUrlPattern;
    private $exposeUrlPattern;
    private $sqliteFile;
    private $emailTemplate;
    private $consoleTemplate;
    private $mailSender;
    private $mailReceiver;
    private $mailSubject;

    protected function __construct()
    {
        
    }

    public static function load(Array $config)
    {
        if (self::$instance === null)
        {
            self::$instance = new Config();
        }

        // debug config
        self::$instance->debug = $config['debug'];

        // search config
        self::$instance->searchIncludeNew     = $config['search']['include']['new'];
        self::$instance->searchIncludeChanged = $config['search']['include']['changed'];
        
        self::$instance->searchExclude        = $config['search']['exclude'];
        
        self::$instance->searchState          = $config['search']['state'];
        self::$instance->searchCity           = $config['search']['city'];
        self::$instance->searchDistricts      = $config['search']['districts'];
        
        self::$instance->searchMinArea        = $config['search']['area']['min'];
        self::$instance->searchMaxArea        = $config['search']['area']['max'];
        
        self::$instance->searchMinRooms       = $config['search']['rooms']['min'];
        self::$instance->searchMaxRooms       = $config['search']['rooms']['max'];

        self::$instance->searchMinRent        = $config['search']['rent']['min'];
        self::$instance->searchMaxRent        = $config['search']['rent']['max'];

        // url config
        self::$instance->searchUrlPattern     = $config['search_url_pattern'];
        self::$instance->exposeUrlPattern     = $config['expose_url_pattern'];

        // db config
        self::$instance->sqliteFile           = $config['sqlite_file'];

        // template config
        self::$instance->emailTemplate        = $config['email_template'];
        self::$instance->consoleTemplate      = $config['console_template'];

        // mail config
        self::$instance->mailSender           = $config['mail_sender'];
        self::$instance->mailReceiver         = $config['mail_receiver'];
        self::$instance->mailSubject          = $config['mail_subject']; 
    }

    public static function getDebug()
    {
        return self::$instance->debug;
    }

    public static function getSearchIncludeNew()
    {
        return self::$instance->searchIncludeNew;
    }

    public static function getSearchIncludeChanged()
    {
        return self::$instance->searchIncludeChanged;
    }

    public static function getSearchExclude()
    {
        return self::$instance->searchExclude;
    }

    public static function getSearchState()
    {
        return self::$instance->searchState;
    }

    public static function getSearchCity()
    {
        return self::$instance->searchCity;
    }

    public static function getSearchDistricts()
    {
        return self::$instance->searchDistricts;
    }

    public static function getSearchMinArea()
    {
        return self::$instance->searchMinArea;
    }

    public static function getSearchMaxArea()
    {
        return self::$instance->searchMaxArea;
    }

    public static function getSearchMinRooms()
    {
        return self::$instance->searchMinRooms;
    }

    public static function getSearchMaxRooms()
    {
        return self::$instance->searchMaxRooms;
    }

    public static function getSearchMinRent()
    {
        return self::$instance->searchMinRent;
    }

    public static function getSearchMaxRent()
    {
        return self::$instance->searchMaxRent;
    }

    public static function getSearchUrlPattern()
    {
        return self::$instance->searchUrlPattern;
    }

    public static function getExposeUrlPattern()
    {
        return self::$instance->exposeUrlPattern;
    }

    public static function getSqliteFile()
    {
        return self::$instance->sqliteFile;
    }

    public static function getEmailTemplate()
    {
        return self::$instance->emailTemplate;
    }

    public static function getConsoleTemplate()
    {
        return self::$instance->consoleTemplate;
    }

    public static function getMailSender()
    {
        return self::$instance->mailSender;
    }

    public static function getMailReceiver()
    {
        return self::$instance->mailReceiver;
    }

    public static function getMailSubject()
    {
        return self::$instance->mailSubject;
    }
}
