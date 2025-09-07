<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/ClienteController.php";
$controller = new ClienteController();
$clientes = $controller->index();
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Lista de Clientes</h2>
    <div class="mb-3">
        <a href="criar.php" class="btn btn-success">Novo Cliente</a>
        <a href="../dashboard.php" class="btn btn-secondary">⬅ Voltar ao Dashboard</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['telefone'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="deletar.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Deseja realmente excluir este cliente?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include "../footer.php"; ?>