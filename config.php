<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prenotazioni_evento";

// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
