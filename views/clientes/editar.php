<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/ClienteController.php";
$controller = new ClienteController();

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$cliente = $controller->edit($id);

if ($_POST) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($controller->update($id, $nome, $email, $telefone)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao atualizar cliente.";
    }
}
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Editar Cliente</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $cliente['nome'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $cliente['email'] ?>">
        </div>
        <div class="mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?= $cliente['telefone'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="listar.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php include "../footer.php"; ?>