<?php
session_start();
include '../config.php';

// Controllo autenticazione
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Connessione al database e fetch delle prenotazioni
$sql = "SELECT * FROM reservation ORDER BY DATA, ORA";
$result = $conn->query($sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Admin - Prenotazioni</title>
</head>
<body>
    <div class="container">
        <h1>Gestione Prenotazioni</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nominativo</th>
                    <th>Telefono</th>
                    <th>Data</th>
                    <th>Ora</th>
                    <th>Persone</th>
                    <th>Note</th>
                    <th>Conferma</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["ID"] . "</td>";
                        echo "<td>" . $row["NOMINATIVO"] . "</td>";
                        echo "<td>" . $row["TELEFONO"] . "</td>";
                        echo "<td>" . $row["DATA"] . "</td>";
                        echo "<td>" . $row["ORA"] . "</td>";
                        echo "<td>" . $row["PERSONE"] . "</td>";
                        echo "<td>" . $row["NOTE"] . "</td>";
                        echo "<td>";
                        if ($row["FLGVIEW"] == 'N') {
                            echo "<form method='post' action='conferma.php'>
                                    <input type='hidden' name='id' value='" . $row["ID"] . "'>
                                    <button type='submit' class='btn btn-success'>Conferma</button>
                                  </form>";
                        } else {
                            echo "Confermata";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nessuna prenotazione trovata</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
