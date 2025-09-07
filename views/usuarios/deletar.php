<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/UsuarioController.php";
$controller = new UsuarioController();
$controller->destroy($_GET['id']);
header("Location: listar.php");
exit;
