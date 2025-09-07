<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}


require_once "../../controllers/ChamadoController.php";
require_once "../../controllers/ClienteController.php";
require_once "../../controllers/UsuarioController.php";

// Controllers
$chamadoController = new ChamadoController();
$clienteController = new ClienteController();
$usuarioController = new UsuarioController();

// Dados para selects
$clientes = $clienteController->index();
$usuarios = $usuarioController->index();

$erro = "";

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Garante que usuario_id venha do select ou da sessão
    $usuario_id = isset($_POST['usuario_id']) && $_POST['usuario_id'] != ''
        ? $_POST['usuario_id']
        : $_SESSION['usuario_id'];

    $dados = [
        'cliente_id' => $_POST['cliente_id'],
        'usuario_id' => $usuario_id,
        'tipo' => $_POST['tipo'],
        'assunto' => $_POST['assunto'],
        'situacao' => $_POST['situacao'],
        'data_inicial' => $_POST['data_inicial'],
        'hora_inicial' => $_POST['hora_inicial'],
        'data_final' => $_POST['data_final'],
        'hora_final' => $_POST['hora_final'],
        'descricao' => $_POST['descricao']
    ];

    if ($chamadoController->store($dados)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar chamado.";
    }
}
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h4>Atendimento</h4>
    <br>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="bi bi-telephone-outbound-fill"></i>
                    <h4 style="font-size: 1rem; padding-left: 15px">Dados do Atendimentos</h4>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <br><br>

                    <div>

                        <form method="POST">
                            <div class="mb-3">
                                <label>Cliente</label>
                                <select name="cliente_id" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php while ($c = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Tipo</label>
                                <select name="tipo" class="form-control" required>
                                    <option>Suporte</option>
                                    <option>Reunião Tira Dúvida</option>
                                    <option>Treinamento</option>
                                    <option>Reunião Externa</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Situação</label>
                                <select name="situacao" class="form-control" required>
                                    <option>Aberto</option>
                                    <option>Andamento</option>
                                    <option>Concluído</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Data Inicial</label>
                                    <input type="date" name="data_inicial" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label>Hora Inicial</label>
                                    <input type="time" name="hora_inicial" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Data Final</label>
                                    <input type="date" name="data_final" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="col">
                                    <label>Hora Final</label>
                                    <input type="time" name="hora_final" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Usuário</label>
                                <select name="usuario_id" class="form-control">
                                    <option value="">Selecione (ou será o logado)</option>
                                    <?php while ($u = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['nome'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Assunto</label>
                                <input type="text" name="assunto" class="form-control" required>
                            </div>


                            <div class="mb-3">
                                <label>Descrição</label>
                                <textarea name="descricao" class="form-control" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Salvar</button>
                            <a href="listar.php" class="btn btn-secondary">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <?php include "../footer.php"; ?>