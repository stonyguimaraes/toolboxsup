<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../../controllers/ChamadoController.php";
require_once "../../controllers/ClienteController.php";
require_once "../../controllers/UsuarioController.php";

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->index(); // retorna todos os usuários


$clienteController = new ClienteController();
$clientes = $clienteController->index();
$controller = new ChamadoController();

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$chamado = $controller->edit($id);

if ($_POST) {
    if ($controller->update($id, $_POST)) {
        header("Location: listar.php");
        exit;
    } else {
        $erro = "Erro ao atualizar chamado.";
    }
}
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h4>Editar Atendimento</h4>
    <br>
    <!--  -->

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
                                    <?php while ($c = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $chamado['cliente_id'] ? 'selected' : '' ?>>
                                            <?= $c['nome'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tipo</label>
                                <select name="tipo" class="form-control" required>
                                    <?php foreach (['Suporte', 'Reunião Tira Dúvida', 'Treinamento', 'Reunião Externa'] as $tipo): ?>
                                        <option <?= $tipo == $chamado['tipo'] ? 'selected' : '' ?>><?= $tipo ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Situação</label>
                                <select name="situacao" class="form-control" required>
                                    <?php foreach (['Aberto', 'Andamento', 'Concluído'] as $sit): ?>
                                        <option <?= $sit == $chamado['situacao'] ? 'selected' : '' ?>><?= $sit ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>Data Inicial</label>
                                    <input type="date" name="data_inicial" class="form-control" value="<?= $chamado['data_inicial'] ?>" required>
                                </div>
                                <div class="col">
                                    <label>Hora Inicial</label>
                                    <input type="time" name="hora_inicial" class="form-control" value="<?= $chamado['hora_inicial'] ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>Data Final</label>
                                    <input type="date" name="data_final" class="form-control" value="<?= $chamado['data_final'] ?>">
                                </div>
                                <div class="col">
                                    <label>Hora Final</label>
                                    <input type="time" name="hora_final" class="form-control" value="<?= $chamado['hora_final'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Usuário</label>
                                <select name="usuario_id" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php
                                    $usuarios = (new UsuarioController())->index();
                                    while ($u = $usuarios->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                        <option value="<?= $u['id'] ?>" <?= $u['id'] == $chamado['usuario_id'] ? 'selected' : '' ?>>
                                            <?= $u['nome'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Assunto</label>
                                <input type="text" name="assunto" class="form-control" value="<?= $chamado['assunto'] ?>" required>
                            </div>



                            <div class="mb-3">
                                <label>Descrição</label>
                                <textarea name="descricao" class="form-control" rows="4"><?= $chamado['descricao'] ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="listar.php" class="btn btn-secondary">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../footer.php"; ?>