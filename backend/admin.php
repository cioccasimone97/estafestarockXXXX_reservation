<?php
session_start();
include '../config.php'; // Includi il file di configurazione per la connessione al database

// Controllo autenticazione
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Query per ottenere le prenotazioni ordinate per data
$sql = "SELECT * FROM reservation ORDER BY DATA DESC";
$result = $conn->query($sql);

// Array per contare le prenotazioni per ogni data
$count_by_date = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date = $row['DATA'];
        if (!isset($count_by_date[$date])) {
            $count_by_date[$date] = 1;
        } else {
            $count_by_date[$date]++;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Stile per rendere la tabella responsive */
        @media (max-width: 767.98px) {
            table.table { min-width: 100% !important; }
        }

        /* Stile per il bottone di logout in alto a destra */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* Stile per i box totalizzatori */
        .total-box {
            width: 150px; /* Larghezza fissa per i box */
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-block;
        }

        /* Colori diversi per i box totalizzatori */
        <?php
        $color_index = 0;
        $colors = array('#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8'); // Array di colori
        foreach ($count_by_date as $date => $count) {
            $formatted_date = date('Y-m-d', strtotime($date)); // Formato data per attributo data-date
            echo ".total-box[data-date='$formatted_date'] { background-color: " . $colors[$color_index] . "; }\n";
            $color_index++;
            if ($color_index >= count($colors)) {
                $color_index = 0; // Ricomincia dall'inizio se esauriti i colori
            }
        }
        ?>
    </style>
    <title>Admin - Prenotazioni</title>
</head>
<body>
    <div class="container">
        <h1>Gestione Prenotazioni</h1>
        <!-- Box totalizzatori -->
        <?php
        foreach ($count_by_date as $date => $count) {
            $formatted_date = date('d-m-Y', strtotime($date));
            echo "<div class='total-box' data-date='$date'>Data: $formatted_date<br>Totale: $count</div>";
        }
        ?>
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
        <div class="table-responsive">
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
                    // Connessione già inclusa in config.php, non serve qui
                    $sql = "SELECT * FROM reservation ORDER BY ID DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["ID"] . "</td>";
                            echo "<td>" . $row["NOMINATIVO"] . "</td>";
                            echo "<td>" . $row["TELEFONO"] . "</td>";
                            // Formattazione della data nel formato GG-MM-YYYY
                            $formatted_date = date('d-m-Y', strtotime($row["DATA"]));
                            echo "<td>" . $formatted_date . "</td>";
                            // Rimuovere i secondi dalla colonna ORA
                            $formatted_time = substr($row["ORA"], 0, 5);
                            echo "<td>" . $formatted_time . "</td>";
                            echo "<td>" . $row["PERSONE"] . "</td>";
                            echo "<td>" . $row["NOTE"] . "</td>";
                            echo "<td>";
                            if ($row["FLGVIEW"] == 'N') {
                                echo "<form method='post' action='conferma.php'>
                                        <input type='hidden' name='id' value='" . $row["ID"] . "'>
                                        <button type='submit' class='btn btn-success'>
                                            <i class='fas fa-check'></i> <!-- Icona di spunta -->
                                        </button>
                                      </form>";
                            } else {
                                echo "<span class='text-success'><i class='fas fa-check'></i></span>"; // Icona di spunta confermata
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Nessuna prenotazione trovata</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
