<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config.php';

$sql = "SELECT * FROM reservation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Admin - Prenotazioni</title>
</head>
<body>
    <h1>Elenco Prenotazioni</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nominativo</th>
            <th>Telefono</th>
            <th>Data Evento</th>
            <th>Ora Evento</th>
            <th>Numero di Persone</th>
            <th>Note</th>
            <th>RAND_UID</th>
            <th>Data Prenotazione</th>
            <th>Ultimo Aggiornamento</th>
            <th>FLGVIEW</th>
            <th>Azioni</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["ID"]."</td>
                        <td>".$row["NOMINATIVO"]."</td>
                        <td>".$row["TELEFONO"]."</td>
                        <td>".$row["DATA"]."</td>
                        <td>".$row["ORA"]."</td>
                        <td>".$row["PERSONE"]."</td>
                        <td>".$row["NOTE"]."</td>
                        <td>".$row["RAND_UID"]."</td>
                        <td>".$row["UPDTMS"]."</td>
                        <td>".$row["FLGVIEW"]."</td>
                        <td><a href='conferma.php?id=".$row["ID"]."'>Conferma</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='12'>Nessuna prenotazione trovata</td></tr>";
        }
        ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
