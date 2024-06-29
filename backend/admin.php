<?php
session_start();
include '../config.php'; // Includi il file di configurazione per la connessione al database

// Controllo autenticazione
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Gestione della conferma della prenotazione
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql_update = "UPDATE reservation SET FLGCONF='S', UPDTMS=NOW() WHERE ID=$id";

    if ($conn->query($sql_update) === TRUE) {
        // Prenotazione confermata con successo
        header("Location: admin.php");
        exit();
    } else {
        // Errore durante l'aggiornamento della prenotazione
        echo "Errore durante la conferma: " . $conn->error;
    }
}

// Query per ottenere le statistiche delle prenotazioni ordinate per data
$sql_stats = "SELECT DATA, COUNT(ID) AS total, SUM(CASE WHEN FLGCONF = 'S' THEN 1 ELSE 0 END) AS confermati 
             FROM reservation 
             GROUP BY DATA 
             ORDER BY DATA DESC";
$result_stats = $conn->query($sql_stats);

// Array per contare le prenotazioni e il numero di confermati per ogni data
$count_by_date = array();

if ($result_stats->num_rows > 0) {
    while($row = $result_stats->fetch_assoc()) {
        $date = $row['DATA'];
        $count_by_date[$date] = array(
            'total' => $row['total'],
            'confermati' => $row['confermati']
        );
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
        foreach ($count_by_date as $date => $counts) {
            $formatted_date = date('Y-m-d', strtotime($date)); // Formato data per attributo data-date
            $total = $counts['total'];
            $confermati = $counts['confermati'];
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
        foreach ($count_by_date as $date => $counts) {
            $formatted_date = date('d-m-Y', strtotime($date));
            $total = $counts['total'];
            $confermati = $counts['confermati'];
            echo "<div class='total-box' data-date='$date'>Data: $formatted_date<br>Totale: $total<br>Confermati: $confermati</div>";
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
                    // Query per ottenere le prenotazioni ordinate per ID
                    $sql_reservations = "SELECT * FROM reservation ORDER BY ID DESC";
                    $result_reservations = $conn->query($sql_reservations);

                    if ($result_reservations->num_rows > 0) {
                        while($row = $result_reservations->fetch_assoc()) {
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
                            if ($row["FLGCONF"] == 'N') {
                                echo "<form method='post' action=''S>
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
