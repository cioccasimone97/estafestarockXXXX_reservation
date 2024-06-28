<?php
include 'config.php';

$nominativo = $_POST['nominativo'];
$telefono = $_POST['telefono'];
$data_evento = $_POST['data_evento'];
$ora_evento = $_POST['ora_evento'];
$note = $_POST['note'];
$ip_richiesta = $_SERVER['REMOTE_ADDR'];

$sql = "INSERT INTO prenotazioni (nome, telefono, data_evento, ora_evento, note, ip_richiesta)
VALUES ('$nominativo', '$telefono', '$data_evento', '$ora_evento', '$note', '$ip_richiesta')";

if ($conn->query($sql) === TRUE) {
    // Numero di telefono predefinito per il messaggio WhatsApp
    $whatsapp_number = '1234567890';
    $message = urlencode("Nuova prenotazione:\nNominativo: $nominativo\nTelefono: $telefono\nData: $data_evento\nOra: $ora_evento\nNote: $note");
    $whatsapp_url = "https://wa.me/$whatsapp_number?text=$message";
    echo "<script type='text/javascript'>window.location.href='$whatsapp_url';</script>";
    echo "Prenotazione effettuata con successo! Verrai reindirizzato a WhatsApp.";
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
