<?php
include 'config.php';

$nominativo = $_POST['nominativo'];
$telefono = $_POST['telefono'];
$data_evento = $_POST['data_evento'];
$ora_evento = $_POST['ora_evento'];
$numero_persone = $_POST['numero_persone'];
$note = $_POST['note'];
$rand_uid = uniqid('', true);
$ip = $_SERVER['REMOTE_ADDR'];

$sql = "INSERT INTO reservation (NOMINATIVO, TELEFONO, DATA, ORA, PERSONE, NOTE, RAND_UID, UPDTMS, FLGCONF)
VALUES ('$nominativo', '$telefono', '$data_evento', '$ora_evento', $numero_persone, '$note', '$rand_uid', NOW(), 'N')";

if ($conn->query($sql) === TRUE) {
    // Numero di telefono predefinito per il messaggio WhatsApp
    $whatsapp_number = '3492982845';
    $message = urlencode("Nuova prenotazione:\nNominativo: $nominativo\nTelefono: $telefono\nData: $data_evento\nOra: $ora_evento\nNumero di persone: $numero_persone\nNote: $note");
    $whatsapp_url = "https://wa.me/$whatsapp_number?text=$message";
    echo "<script type='text/javascript'>window.location.href='$whatsapp_url';</script>";
    echo "Prenotazione effettuata con successo! Verrai reindirizzato a WhatsApp.";
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
