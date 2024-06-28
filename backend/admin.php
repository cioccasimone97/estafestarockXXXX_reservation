<?php
session_start();
include '../config.php';

// Controllo autenticazione
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Configurazione del paging
$results_per_page = 25;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $results_per_page;

// Connessione al database e fetch delle prenotazioni
$sql = "SELECT * FROM reservation ORDER BY ID DESC LIMIT $start_from, $results_per_page";
$result = $conn->query($sql);

// Ottieni il numero totale di prenotazioni
$sql_total = "SELECT COUNT(ID) AS total FROM reservation";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_pages = ceil($row_total['total'] / $results_per_page);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin - Prenotazioni</title>
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

        /* Stile per il corpo della tabella con scroll infinito */
        .table-wrapper {
            max-height: 600px; /* Altezza massima della tabella con scroll */
            overflow-y: auto; /* Abilita lo scroll verticale se necessario */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
        <h1>Gestione Prenotazioni</h1>
        <div class="table-responsive table-wrapper">
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
                <tbody id="table-body">
                    <?php
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
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Navigazione del paging (Javascript per lo scroll infinito) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                var page = <?php echo $page; ?>;
                var total_pages = <?php echo $total_pages; ?>;
                var loading = false;

                $(window).scroll(function() {
                    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                        if (page < total_pages && !loading) {
                            loading = true;
                            page++;
                            var url = 'admin.php?page=' + page;
                            $.get(url, function(data) {
                                $("#table-body").append(data);
                                loading = false;
                            });
                        }
                    }
                });
            });
        </script>
    </div>
</body>
</html>
