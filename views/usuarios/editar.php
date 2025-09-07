<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/UsuarioController.php";
$controller = new UsuarioController();

$usuario = $controller->show($_GET['id']);

if ($_POST) {
    $_POST['id'] = $_GET['id'];
    if ($controller->update($_POST)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao atualizar usuário!";
    }
}
?>
<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Editar Usuário</h2>
    <?php if (isset($erro)) echo "<p class='text-danger'>$erro</p>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $usuario['nome'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include "../footer.php"; ?>