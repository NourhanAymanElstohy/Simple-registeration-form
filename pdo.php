<?php
// require_once "config.php";
// $host = HOST;
// $port = PORT;
// $DB = DATABASE;
//======================
$pg_host = "ec2-107-22-7-9.compute-1.amazonaws.com";
$pg_db = "df9328haf3ikkm host=ec2-107-22-7-9.compute-1.amazonaws.com";
$pg_user = "wfyekatjhpordw";
$pg_password = "09d1295dae089785ba8ad59e6c5de2ebaf548d383dd002796464a1b0405bdbec";
$pg_port = "5432";

$pg_dsn = "pgsql:host=" . $pg_host . ";port=" . $pg_port . ";dbname=" . $pg_db;
$db = new PDO($pg_dsn, $pg_user, $pg_password);
// $db = new PDO("mysql:host=$host; port=$port; dbname=$DB", USER, PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
