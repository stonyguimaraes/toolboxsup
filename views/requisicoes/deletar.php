<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../controllers/RequisicaoController.php";

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$controller = new RequisicaoController();
$controller->destroy($id);

header("Location: listar.php");
exit;
