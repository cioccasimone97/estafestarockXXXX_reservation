<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config.php';

$sql = "SELECT * FROM prenotazioni";
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
            <th>Note</th>
            <th>Data Prenotazione</th>
            <th>Ultimo Aggiornamento</th>
            <th>IP Richiesta</th>
            <th>Confermata</th>
            <th>Azioni</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["nome"]."</td>
                        <td>".$row["telefono"]."</td>
                        <td>".$row["data_evento"]."</td>
                        <td>".$row["ora_evento"]."</td>
                        <td>".$row["note"]."</td>
                        <td>".$row["data_prenotazione"]."</td>
                        <td>".$row["update_timestamp"]."</td>
                        <td>".$row["ip_richiesta"]."</td>
                        <td>".($row["confermata"] ? "Sì" : "No")."</td>
                        <td><a href='conferma.php?id=".$row["id"]."'>Conferma</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Nessuna prenotazione trovata</td></tr>";
        }
        ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
