<?php

require 'vendor/autoload.php';
include_once "config.php";

// query di inserimento preparata
$sql = "SELECT * FROM prenotazioni WHERE prenotazioni.giorno = CURDATE()";

use League\Plates\Engine;

// viene creato l'oggetto per la gestione dei template
$templates = new Engine('./view', 'tpl');

$stmt = $pdo->query($sql);

// estraggo le righe di risposta che finiranno come vettori
$result = $stmt->fetchAll();

$mesi = ['gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];

function convertiData($row) {
    GLOBAL $mesi;
    $giorno = date("d", strtotime($row['giorno']));
    $mese = date("m", strtotime($row['giorno']));
    $anno = date("Y", strtotime($row['giorno']));
    $row['giorno'] = $giorno.' '.$mesi[(int) $mese].' '.$anno;
    return $row;
}

$result = array_map('convertiData', $result);
$today = convertiData(['giorno' => date('d-m-Y')])['giorno'];

// rendo un template che mi visualizza le tabelle
echo $templates->render('lista_prenotazioni_giornaliere', ['result' => $result, 'today' => $today]);