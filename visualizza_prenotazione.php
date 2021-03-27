<?php

include_once "config.php";

// variabili valorizzate tramite POST
$codice_fiscale = $_POST['codice_fiscale'];
$codice_prenotazione = $_POST['codice_prenotazione'];

// query di inserimento preparata
$sql = "SELECT * FROM prenotazioni
        WHERE prenotazioni.codice = '$codice_prenotazione'";

$stmt = $pdo->query($sql);

$table= ' <table>
    <tr>
      <th>CODICE PRENOTAZIONE</th>
      <th>CODICE FISCALE</th>
      <th>GIORNO</th>
    </tr>';

$prenotazione = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

// aggiungo i dati alla tabella
$table .= "
<tr>
    <td>$prenotazione[codice]</td>
    <td>$prenotazione[codice_fiscale]</td>
    <td>$prenotazione[giorno]</td>
</tr>
";

$table .= '</table>';

echo $table;