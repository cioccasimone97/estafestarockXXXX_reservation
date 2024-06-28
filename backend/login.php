<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Questi dovrebbero essere salvati in modo sicuro, per esempio nel database
    $admin_username = 'admin';
    $admin_password = 'password'; // Assicurati di usare hash per le password in produzione

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
    }
}
?>
