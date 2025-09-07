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


<?php include "mensagem.php"; ?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Suporte Ileva</title>
    <link rel="icon" type="image/png" href="../resource/ileva.png">
    <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        /* Sidebar */
        #sidebar {
            width: 220px;
            min-width: 220px;
            transition: all 0.3s;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 60px;
            /* Espaço para navbar */
            z-index: 1000;
        }

        #sidebar.minimized {
            width: 60px;
            min-width: 60px;
        }

        #sidebar .nav-link {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sidebar .menu-text {
            transition: opacity 0.3s;
        }

        #sidebar.minimized .menu-text {
            opacity: 0;
        }

        /* Conteúdo principal */
        #content {
            margin-left: 220px;
            transition: margin-left 0.3s;
            padding: 20px;
        }

        #sidebar.minimized~#content {
            margin-left: 60px;
        }

        /* Navbar */
        .navbar-custom {
            position: fixed;
            width: 100%;
            z-index: 1001;
        }

        @media (max-width: 768px) {
            #sidebar {
                left: -220px;
            }

            #sidebar.show {
                left: 0;
            }

            #sidebar.minimized {
                width: 220px;
            }

            #content {
                margin-left: 0;
            }

            #sidebar.show~#content {
                margin-left: 220px;
            }
        }
    </style>
</head>

<body style="background-color: #dfdfdfff;">

    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
        <div class="container-fluid">
            <button class="btn btn-outline-primary me-2" id="btn-toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>

            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <img src="https://www.ileva.com.br/website/img/Icones/logo.png" width="140" height="40" class="d-inline-block align-top" alt="">
                <span style="font-size: 1.5rem; margin-left: 5px;">| Suporte</span>
            </a>

            <div class="ms-auto d-flex align-items-center">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <span class="text-dark me-2">Olá, <?= $_SESSION['usuario_nome'] ?></span>
                    <a href="../views/logout" class="btn btn-danger btn-sm">Sair</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Sidebar lateral -->
    <div id="sidebar" class="sidebar d-flex flex-column">
        <div class="menu-title px-3 py-2 fw-bold">📂 Menu</div>
        <nav class="nav flex-column">
            <a href="?page=home" class="nav-link px-3 py-2"><i class="bi bi-speedometer2"></i> <span class="menu-text ms-2">Dashboard</span></a>
            <a href="?page=chamados" class="nav-link px-3 py-2"><i class="bi bi-card-checklist"></i> <span class="menu-text ms-2">Chamados</span></a>
            <a href="clientes" class="nav-link px-3 py-2"><i class="bi bi-people"></i> <span class="menu-text ms-2">Clientes</span></a>
            <a href="../views/usuarios/listar.php" class="nav-link px-3 py-2"><i class="bi bi-person"></i> <span class="menu-text ms-2">Usuários</span></a>
        </nav>
    </div>

    <!-- Conteúdo principal -->
    <div id="content">
        <button class="btn btn-outline-primary me-2" id="btn-toggle-sidebar">
            <i class="bi bi-list"></i>
        </button>