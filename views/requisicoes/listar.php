<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../controllers/RequisicaoController.php";
$controller = new RequisicaoController();
$requisicoes = $controller->index();
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Lista de Requisições</h2>
    <div class="mb-3">
        <a href="criar.php" class="btn btn-success">Nova Requisição</a>
        <a href="../dashboard.php" class="btn btn-secondary">⬅ Voltar ao Dashboard</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Data</th>
                <th>Colaborador</th>
                <th>Sugestão</th>
                <th>Previsão de Entrega</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $requisicoes->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['cliente_nome'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td><?= $row['colaborador'] ?></td>
                    <td><?= $row['sugestao'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['previsao_entrega'])) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="deletar.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Deseja realmente excluir esta requisição?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include "../footer.php"; ?>