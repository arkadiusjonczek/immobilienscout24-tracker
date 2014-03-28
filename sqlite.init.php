<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config.php';

$sql = 'CREATE TABLE entries(
id INT NOT NULL,
created_at DATETIME NOT NULL,
title VARCHAR(150) NOT NULL,
subtitle VARCHAR(150) NOT NULL,
price VARCHAR(10) NOT NULL,
area VARCHAR(10) NOT NULL,
rooms VARCHAR(10) NOT NULL,
url VARCHAR(255) NOT NULL,
picture_url VARCHAR(255) NOT NULL)';

try
{
    $db_file = $config['sqlite_file'];
    $pdo = new PDO('sqlite:' . $db_file);
    $stmt = $pdo->query($sql);
    
    return true;
}
catch (Exception $exception)
{
    echo $exception;

    return false;
}