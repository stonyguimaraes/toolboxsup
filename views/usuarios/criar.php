<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/UsuarioController.php";

if ($_POST) {
    $controller = new UsuarioController();
    if ($controller->store($_POST)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao criar usuário!";
    }
}
?>
<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Novo Usuário</h2>
    <?php if (isset($erro)) echo "<p class='text-danger'>$erro</p>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include "../footer.php"; ?>