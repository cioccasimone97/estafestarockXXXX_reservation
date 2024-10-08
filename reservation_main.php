<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $date = $_POST['date'];
    $ora = $_POST['ora'];
    $persone = $_POST['persone'];
    $note = $_POST['note'];
    $ip = $_SERVER['REMOTE_ADDR'];

    // Preparazione della query per l'inserimento della prenotazione
    $sql = "INSERT INTO reservation (NOMINATIVO, TELEFONO, DATA, ORA, PERSONE, NOTE, RAND_UID, IP_REQUEST) VALUES (?, ?, ?, ?, ?, ?, UUID(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiss", $name, $phoneNumber, $date, $ora, $persone, $note, $ip);

    if ($stmt->execute()) {
        $reservationID = $stmt->insert_id;
        $stmt->close();
        $conn->close();

        // Preparazione del messaggio per WhatsApp
        $message = urlencode(
            ".         _*ESTAFESTAROCK XXXX*_ \n\n" .
            "===========================\n" .
            "*Richiesta prenotazione tavolo*\n" .
            "Nome e Cognome: " . $name . "\n" .
            "Telefono: " . $phoneNumber . "\n" .
            "Data: " . $date . "\n" .
            "Ora: " . $ora . "\n" .
            "Persone: " . $persone . "\n" .
            "Note: " . $note . "\n" .
            "===========================\n" .
            "> _----- PRENOTAZIONE N " . $reservationID . "  -----_"
        );

        // URL di WhatsApp per l'invio del messaggio
        $whatsapp_number='3492982845';
        $whatsappUrl = "https://wa.me/".$whatsapp_number."?text=" . $message;
        
        // Messaggio
        $confirm_message = "Prenotazione effettuata con successo! Ora verrai reindirizzato a WhatsApp, invia il messaggio così come proposto senza apportare modifiche";
        
        // Stampa l'alert e il reindirizzamento
        echo "<script type='text/javascript'>
                alert('$confirm_message');
                window.location.href='$whatsappUrl';
              </script>";
        exit();
    } else {
        echo "Errore durante la prenotazione. Riprova più tardi.";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <style>@import url('https://fonts.cdnfonts.com/css/potato-sans');</style>
    <title>ESTAFESTAROCK XXXX</title>
</head>
<body>
    <div class="container">
        <h1>ESTAFESTAROCK XXXX</h1>
        <h4>Prenota un tavolo</h4>
        <h6><a href="https://instagram.com/estafestarock?igshid=MzRlODBiNWFlZA==" style="color:#c2382e;" target="_blank">@estafestarock</a> <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512"><style>svg{fill:#c2382e}</style><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg> <a href="https://instagram.com/gruppogiovanimontello?igshid=MzRlODBiNWFlZA==" style="color:#c2382e;" target="_blank">@gruppogiovanimontello</a></h6>
        <form method="post" action="">
            <div class="form-group">
                <label for="name" class="form-label lb-lg">Nominativo *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome e Cognome" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber" class="form-label lb-lg">Telefono *</label>
                <input type="tel" id="phoneNumber" class="form-control" name="phoneNumber" placeholder="1234567890" required>
            </div>

            <div class="form-group">
                <label for="date" class="form-label lb-lg">Data *</label>
                <select name="date" id="date" class="form-control" required>
                    <option value="2024-07-16">Martedì - 16/07/2024</option>
                    <option value="2024-07-17">Mercoledì - 17/07/2024</option>
                    <option value="2024-07-18">Giovedì - 18/07/2024</option>
                    <option value="2024-07-19">Venerdì - 19/07/2024</option>
                    <option value="2024-07-20">Sabato - 20/07/2024</option>
                    <option value="2024-07-21">Domenica - 21/07/2024</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ora" class="form-label lb-lg">Ora *</label>
                <select name="ora" id="ora" class="form-control" required>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                </select>
            </div>

            <div class="form-group">
                <label for="persone" class="form-label lb-lg">Persone *</label>
                <select name="persone" id="persone" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label for="note" class="form-label lb-lg">Note</label>
                <input type="text" id="note" class="form-control" name="note" placeholder="Aggiungi eventuali richieste o note">
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Richiedi prenotazione tramite WhatsApp</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            for (var i = 1; i <= 10; i++) {
                $('#persone').append('<option value="' + i + '">' + i + '</option>');
            }
        });
    </script>
</body>
</html>