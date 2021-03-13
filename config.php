<?php


ini_set('display_errors', 1);
ini_set('log_errors', 0);

$host = 'local_host';
$db = 'tampone';
$user = 'root';
$pass = 'pass';

//Stringa di connessione
$dsn = 'mysql:host=' . $host . ';dbname=' . $db;


$pdo = new PDO($dsn, $user, $pass);