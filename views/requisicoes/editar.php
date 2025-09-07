<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../controllers/RequisicaoController.php";
require_once "../../controllers/ClienteController.php";

$controller = new RequisicaoController();
$clienteController = new ClienteController();
$clientes = $clienteController->index();

// Busca a requisição pelo ID
if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$requisicao = $controller->edit($id);

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'cliente_id' => $_POST['cliente_id'],
        'status' => $_POST['status'],
        'data' => $_POST['data'],
        'previsao_entrega' => $_POST['previsao_entrega'],
        'colaborador' => $_POST['colaborador'],
        'sugestao' => $_POST['sugestao']
    ];
    $controller->update($id, $dados);
    header("Location: listar.php");
    exit;
}
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h2>Editar Requisição</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Selecione um Cliente</option>
                <?php while ($c = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $requisicao['cliente_id'] ? 'selected' : '' ?>>
                        <?= $c['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Em avaliação" <?= $requisicao['status'] == 'Em avaliação' ? 'selected' : '' ?>>Em avaliação</option>
                <option value="Vai Atender" <?= $requisicao['status'] == 'Vai Atender' ? 'selected' : '' ?>>Vai Atender</option>
                <option value="Não Vai Atender" <?= $requisicao['status'] == 'Não Vai Atender' ? 'selected' : '' ?>>Não Vai Atender</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Data</label>
            <input type="date" name="data" class="form-control" value="<?= $requisicao['data'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Colaborador</label>
            <input type="text" name="colaborador" class="form-control" value="<?= $requisicao['colaborador'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Sugestão</label>
            <textarea name="sugestao" class="form-control" rows="5"><?= $requisicao['sugestao'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Previsão de Entrega</label>
            <input type="date" name="previsao_entrega" class="form-control"
                value="<?= isset($requisicao) ? $requisicao['previsao_entrega'] : '' ?>" required>
        </div>


        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="listar.php" class="btn btn-secondary">⬅ Voltar</a>
    </form>
</div>

<?php include "../footer.php"; ?>