<?php

namespace Jonczek\Immobilienscout24Tracker;

class ExposeStore
{
    private $pdo;

    public function __construct()
    {

    }

    protected function initialize()
    {
        $sql = 'CREATE TABLE entries(
                id INT NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NULL,
                title VARCHAR(150) NOT NULL,
                subtitle VARCHAR(150) NOT NULL,
                price VARCHAR(10) NOT NULL,
                area VARCHAR(10) NOT NULL,
                rooms VARCHAR(10) NOT NULL,
                picture_url VARCHAR(255) NOT NULL)';
        
        $stmt = $this->pdo->query($sql);
    }

    public function connect()
    {
        $sqliteFile = Config::getSqliteFile();
        $initializeRequired = false;

        // create sqlite database
        if (!file_exists($sqliteFile))
        {
            $initializeRequired = true;
        }

        $this->pdo = new \PDO('sqlite:' . $sqliteFile);

        if ($initializeRequired)
        {
            $this->initialize();
        }
    }

    public function getEntries()
    {
        $entries = array();

        $sql = 'SELECT * FROM entries';

        // get all db entries
        foreach ($this->pdo->query($sql) as $row)
        {
            $id = $row['id'];

            $entry = Expose::createBuilder($id)
                ->withTitle($row['title'])
                ->withSubtitle($row['subtitle'])
                ->withPrice($row['price'])
                ->withArea($row['area'])
                ->withRooms($row['rooms'])
                ->withPictureUrl($row['picture_url'])
                ->build();

            $entries["$id"] = $entry;
        }

        return $entries;
    }

    public function insertEntries($entries)
    {
        foreach ($entries as $entry)
        {
            // attributes: 
            // id, created_at, title, subtitle, price, area, rooms, picture_url
            $stmt = $this->pdo->prepare(
                'INSERT INTO entries 
                 VALUES (?, datetime(\'now\'), NULL, ?, ?, ?, ?, ?, ?)'
            );

            $stmt->execute(
                array(
                    $entry->getId(),
                    $entry->getTitle(),
                    $entry->getSubtitle(),
                    $entry->getPrice(),
                    $entry->getArea(),
                    $entry->getRooms(),
                    $entry->getPictureUrl()
                )
            );
        }
    }

    public function updateEntries($entries)
    {
        foreach ($entries as $entry)
        {
           $stmt = $this->pdo->prepare(
                'UPDATE entries 
                 SET updated_at=datetime(\'now\'), title=?, subtitle=?, 
                     price=?, area=?, rooms=?, picture_url=?
                 WHERE id=?'
            );

            $stmt->execute(
                array(
                    $entry->getTitle(),
                    $entry->getSubtitle(),
                    $entry->getPrice(),
                    $entry->getArea(),
                    $entry->getRooms(),
                    $entry->getPictureUrl(),
                    $entry->getId()
                )
            );
        }
    }
}
