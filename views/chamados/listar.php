<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../controllers/ChamadoController.php";
require_once "../../controllers/UsuarioController.php";

$controller = new ChamadoController();
$usuarioController = new UsuarioController();

// Usuário logado
$usuarioLogado = $_SESSION['usuario_id'];

// Filtros atuais
$filtroUsuario = $_GET['usuario_id'] ?? $usuarioLogado;
$filtroTipo    = $_GET['tipo'] ?? '';
$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10; // padrão 10
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Lista chamados com filtros e paginação
$chamados = $controller->index($filtroUsuario, $registrosPorPagina, $offset, $filtroTipo);

// Total de registros filtrados
$totalChamadosStmt = $controller->index($filtroUsuario, null, null, $filtroTipo);
$totalChamados = $totalChamadosStmt->rowCount();
$totalPaginas = ceil($totalChamados / $registrosPorPagina);

// Lista de usuários para filtro
$usuarios = $usuarioController->index();
?>

<?php include "../header.php"; ?>

<div class="container mt-4">
    <h4>Lista de Chamados</h4>
    <br>
    <a href="criar.php" class="btn btn-secondary">+ Novo Chamado</a>
    <a href="../dashboard.php" class="btn btn-light">⬅ Voltar ao Dashboard</a>
    <br><br>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="bi bi-telephone-outbound-fill"></i>
                    <h4 style="font-size: 1rem; padding-left: 15px">Tabela de Atendimentos</h4>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <br><br>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>

                            <button class="btn btn-outline-primary me-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltro" aria-expanded="false" aria-controls="collapseFiltro">
                                🔍 Filtro
                            </button>
                        </div>

                        <a href="relatorio.php?usuario_id=<?= $_SESSION['usuario_id'] ?>" target="_blank" class="btn" style="background-color:#1A237E;color:#fff;">📄 Relatório</a>
                    </div>
                    <br><br>
                    <!-- Collapse Filtro -->
                    <div class="collapse mb-3" id="collapseFiltro">
                        <div class="card card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label for="usuario_id" class="form-label">Usuário</label>
                                    <select name="usuario_id" id="usuario_id" class="form-select">
                                        <option value="">-- Todos Usuários --</option>
                                        <?php while ($u = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $u['id'] ?>" <?= ($filtroUsuario == $u['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($u['nome']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-select">
                                        <option value="">-- Todos Tipos --</option>
                                        <option value="Suporte" <?= ($filtroTipo == 'Suporte') ? 'selected' : '' ?>>Suporte</option>
                                        <option value="Reunião Tira Dúvida" <?= ($filtroTipo == 'Reunião Tira Dúvida') ? 'selected' : '' ?>>Reunião Tira Dúvida</option>
                                        <option value="Treinamento" <?= ($filtroTipo == 'Treinamento') ? 'selected' : '' ?>>Treinamento</option>
                                        <option value="Reunião Externa" <?= ($filtroTipo == 'Reunião Externa') ? 'selected' : '' ?>>Reunião Externa</option>
                                    </select>
                                </div>

                                <div class="col-md-4 align-self-end">
                                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                                </div>
                            </form>
                        </div>
                    </div>




                    <!-- Texto de registros abaixo da tabela -->
                    <div class="mb-2">
                        <!-- Select de quantidade de registros -->
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <form method="GET" class="d-flex align-items-center">
                                <input type="hidden" name="usuario_id" value="<?= $filtroUsuario ?>">
                                <input type="hidden" name="tipo" value="<?= $filtroTipo ?>">

                                <!-- <label for="registros" class="me-2 mb-0">Mostrar</label> -->
                                <select name="registros" id="registros" class="form-select" style="width: auto;" onchange="this.form.submit()">
                                    <?php foreach ([5, 10, 20, 50, 100] as $op): ?>
                                        <option value="<?= $op ?>" <?= ($registrosPorPagina == $op) ? 'selected' : '' ?>><?= $op ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>

                        </div>
                        <?php
                        $inicio = ($paginaAtual - 1) * $registrosPorPagina + 1;
                        $fim    = min($inicio + $registrosPorPagina - 1, $totalChamados);
                        ?>
                        Mostrando de <?= $inicio ?> até <?= $fim ?> de <?= $totalChamados ?> registros

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light" style="font-size: 0.8rem;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Assunto</th>
                                        <th>Situação</th>
                                        <th>Data Inicial</th>
                                        <th>Hora Inicial</th>
                                        <th>Data Final</th>
                                        <th>Hora Final</th>
                                        <th>Usuário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $chamados->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr style="font-size: 0.8rem;">
                                            <td><?= $row['id'] ?></td>
                                            <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                                            <td><?= htmlspecialchars($row['tipo']) ?></td>
                                            <td><?= htmlspecialchars($row['assunto']) ?></td>
                                            <td>
                                                <?php
                                                $cor = '';
                                                switch ($row['situacao']) {
                                                    case 'Aberto':
                                                        $cor = 'bg-danger text-white';
                                                        break;
                                                    case 'Andamento':
                                                        $cor = 'bg-warning text-dark';
                                                        break;
                                                    case 'Concluído':
                                                        $cor = 'bg-success text-white';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $cor ?>"><?= htmlspecialchars($row['situacao']) ?></span>
                                            </td>
                                            <td><?= date("d/m/Y", strtotime($row['data_inicial'])) ?></td>
                                            <td><?= htmlspecialchars($row['hora_inicial']) ?></td>
                                            <td><?= $row['data_final'] ? date("d/m/Y", strtotime($row['data_final'])) : '' ?></td>
                                            <td><?= htmlspecialchars($row['hora_final']) ?></td>
                                            <td><?= htmlspecialchars($row['usuario_nome']) ?></td>
                                            <td>
                                                <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                                <a href="deletar.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este chamado?')">🗑️</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>


                        </div>

                        <div class="mb-2 d-flex align-items-right justify-content-end">
                            <!-- Paginação à direita -->
                            <?php if ($totalPaginas > 1): ?>
                                <nav aria-label="Navegação de páginas">
                                    <ul class="pagination mb-0">
                                        <li class="page-item <?= ($paginaAtual == 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?usuario_id=<?= $filtroUsuario ?>&tipo=<?= $filtroTipo ?>&registros=<?= $registrosPorPagina ?>&pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
                                        </li>

                                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                            <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                                                <a class="page-link" href="?usuario_id=<?= $filtroUsuario ?>&tipo=<?= $filtroTipo ?>&registros=<?= $registrosPorPagina ?>&pagina=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <li class="page-item <?= ($paginaAtual == $totalPaginas) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?usuario_id=<?= $filtroUsuario ?>&tipo=<?= $filtroTipo ?>&registros=<?= $registrosPorPagina ?>&pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <?php include "../footer.php"; ?>