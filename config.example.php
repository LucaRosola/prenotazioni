<?php

// Esempio di un file di configurazione.
// Creare un file config.php e inserire le seguenti righe
// adattandole alla propria configurazione

// dice a livello dello script che gli errori verranno mostrati e che non verranno loggati
ini_set('display_errors', 1);
ini_set('log_errors', 1);

$host = 'your_host';
$db = 'your_db';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8';

// stringa di connessione
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$pdo = new PDO($dsn, $user, $pass);