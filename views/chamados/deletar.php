<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/ChamadoController.php";
$controller = new ChamadoController();

if (isset($_GET['id'])) {
    $controller->destroy($_GET['id']);
}
header("Location: listar.php");
exit;
