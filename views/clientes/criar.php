<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/ClienteController.php";
$controller = new ClienteController();

if ($_POST) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($controller->store($nome, $email, $telefone)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar cliente.";
    }
}
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Novo Cliente</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="listar.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php include "../footer.php"; ?>