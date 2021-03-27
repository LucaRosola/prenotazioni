<?php

require 'phpqrcode/qrlib.php';
include_once "config.php";

// variabili valorizzate tramite POST
$codice_fiscale = $_POST['codice_fiscale'];
$giorno = $_POST['giorno'];
$codice = strtoupper(uniqid());
$headerMsg = array('class'=>'error', 'message'=>'Prenotazione fallita');
$firstLine = "Sono state effettuate troppe prenotazioni per questa giornata, scegli un altro giorno";

// query di inserimento preparata
$sql = "INSERT INTO prenotazioni VALUES (NULL, :codice_fiscale, :giorno, :codice)";

$sql_numero= "SELECT COUNT(*) AS n_prenotazioni FROM prenotazioni WHERE prenotazioni.giorno = '$giorno'";

$n_prenotazioni = $pdo->query($sql_numero)->fetchAll()[0]["n_prenotazioni"];

if ($n_prenotazioni <= 5) {
    $headerMsg['class'] = 'success';
    $headerMsg['message'] = 'Prenotazione avvenuta con successo';
    // inviamo la query al database che la tiene pronta
    $stmt = $pdo->prepare($sql);

    // inviamo i dati concreti che verranno messi al posto dei segnaposto
    $stmt->execute(
        [
            'codice_fiscale' => $codice_fiscale,
            'giorno' => $giorno,
            'codice' => $codice
        ]
    );
    // $firstLine = "Il codice della tua prenotazione è il seguente: $codice";
    $firstLine = "QR Code contenente il codice della tua prenotazione:";
    $QRCode = QRCodeGenerator($codice);
}

function QRCodeGenerator($data) {
    // ECC Level, livello di correzione dell'errore (valori possibili in ordine crescente: L,M,Q,H - da low a high)
    $errorCorrectionLevel = 'L';

    // Matrix Point Size, dimensione dei punti della matrice (da 1 a 10)
    $matrixPointSize = 4;

    // Il File da salvare (deve essere salvato in una directory scrivibile dal web server)
    $filename = 'qrcode'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

    // Generiamo il QRcode in formato immagine PNG
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    return $filename;
}

function QRCodeGeneratorSimple($data) {
    QRcode::png($data, 'qrcode.png');
    return 'qrcode.png';
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Prenotazione</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <h1 class="<?php echo $headerMsg['class'] ?>"><?php echo $headerMsg['message'] ?></h1>
    <p><?php echo $firstLine ?></p>
    <img src="<?php echo $QRCode ?>" alt="QR Code" width="250px"/>
</div>
</body>
</html>
