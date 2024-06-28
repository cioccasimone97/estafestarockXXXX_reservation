<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prenotazione Tavoli</title>
</head>
<body>
    <h1>Prenotazione Tavoli per l'Evento</h1>
    <form action="prenota.php" method="post">
        <label for="nominativo">Nominativo:</label>
        <input type="text" id="nominativo" name="nominativo" required><br>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <label for="data_evento">Data:</label>
        <input type="date" id="data_evento" name="data_evento" required><br>

        <label for="ora_evento">Ora:</label>
        <input type="time" id="ora_evento" name="ora_evento" required><br>

        <label for="note">Note:</label>
        <textarea id="note" name="note"></textarea><br>

        <label for="numero_persone">Numero di persone:</label>
        <input type="number" id="numero_persone" name="numero_persone" required><br>

        <input type="submit" value="Prenota">
    </form>
</body>
</html>
