<?php
session_start();
require_once "../controllers/UsuarioController.php";
$controller = new UsuarioController();

if ($_POST) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($controller->registrar($nome, $email, $senha)) {
        header("Location: login.php");
        exit;
    } else {
        $erro = "Erro ao registrar usuário.";
    }
}
?>

<?php include "header.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="mb-3">Registrar</h3>
            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>
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
                <button type="submit" class="btn btn-success w-100">Registrar</button>
                <a href="login.php" class="btn btn-link w-100">Já tenho conta</a>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>