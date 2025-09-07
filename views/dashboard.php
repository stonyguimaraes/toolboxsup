<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<?php include "header.php"; ?>

<div class="container mt-4">
    <h2>Dashboard - Suporte Ileva</h2>
    <div class="list-group mt-4">
        <a href="clientes/listar.php" class="list-group-item list-group-item-action">📌 Clientes</a>
        <a href="usuarios/listar.php" class="list-group-item list-group-item-action">👤 Usuários</a>
        <a href="chamados/listar.php" class="list-group-item list-group-item-action">📝 Chamados</a>
        <a href="requisicoes/listar.php" class="list-group-item list-group-item-action">📄 Requisições</a>
    </div>
</div>


<?php include "footer.php"; ?>