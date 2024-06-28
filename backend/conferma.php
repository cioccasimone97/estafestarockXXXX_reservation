<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config.php';

$id = $_GET['id'];

$sql = "UPDATE prenotazioni SET confermata = 1 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Prenotazione confermata con successo!";
} else {
    echo "Errore durante la conferma: " . $conn->error;
}

$conn->close();
?>
<a href="admin.php">Torna all'elenco prenotazioni</a>
