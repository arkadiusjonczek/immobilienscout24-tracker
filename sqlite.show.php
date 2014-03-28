<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!file_exists('config.php'))
{
    die("Config file 'config.php' doesn't exist. Please use 'config.sample.php' to create one.");
}

require_once 'config.php';
require_once 'functions.php';

$sql = 'SELECT * FROM entries ORDER BY created_at DESC, price DESC';

try
{
	$db_file = $config['sqlite_file'];
	$pdo = new PDO('sqlite:' . $db_file);
	$stmt = $pdo->query($sql);
	$entries = $stmt->fetchAll();
	
	$output_body = render($config['template'], array('entries' => $entries));
	
	header("Content-Type: text/html; charset=utf-8");
	echo $output_body;
}
catch (Exception $exception)
{
	echo $exception;
}