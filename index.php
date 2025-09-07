<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se usuário está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: views/dashboard.php");
} else {
    header("Location: views/login.php");
}
exit;
