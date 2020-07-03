<?php
require_once "config.php";
$host = HOST;
$port = PORT;
$DB = DATABASE;
$db = new PDO("mysql:host=$host; port=$port; dbname=$DB", USER, PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
