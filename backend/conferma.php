<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "UPDATE reservation SET FLGVIEW='S', TIMESTAMP=NOW() WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Prenotazione confermata con successo";
    } else {
        echo "Errore durante la conferma: " . $conn->error;
    }

    $conn->close();
    header("Location: admin.php");
    exit();
}
?>
