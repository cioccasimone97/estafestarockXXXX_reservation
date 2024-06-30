<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect</title>
    <script>
        // Funzione per tentare l'apertura del link in un browser esterno
        function openLinkExternally(url) {
            // Metodo 1: Usare window.location.href con un ritardo
            setTimeout(function() {
                window.location.href = url;
            }, 100);

            // Metodo 2: Usare window.open
            window.open(url, '_blank');

            // Metodo 3: Usare Intent URI per Android
            var intentUrl = 'intent://' + url.replace(/^https?:\/\//, '') + '#Intent;scheme=https;package=com.android.chrome;end';
            window.location.href = intentUrl;
        }

        // Al caricamento della pagina, tenta di aprire il link
        window.onload = function() {
            var url = "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/reservation_main.php'; ?>";
            openLinkExternally(url);
        }
    </script>
</head>
<body>
    <h1>Stiamo reindirizzando...</h1>
    <p>Se non vieni reindirizzato automaticamente, <a id="manual-link" href="#">clicca qui</a>.</p>
    <script>
        document.getElementById('manual-link').onclick = function() {
            var url = "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/reservation_main.php'; ?>";
            openLinkExternally(url);
            return false;
        }
    </script>
</body>
</html>
