<?php
require_once "config.php";

// ================ development ==========
// $host = HOST;
// $port = PORT;
// $DB = DATABASE;

// $db = new PDO("mysql:host=$host; port=$port; dbname=$DB", USER, PASSWORD);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//============ production ===============
$pg_dsn = "pgsql:host=" . $pg_host . ";port=" . $pg_port . ";dbname=" . $pg_db;
$pg_db = new PDO($pg_dsn, $pg_user, $pg_password);
$pg_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
