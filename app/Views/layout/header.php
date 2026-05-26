<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilkington - Sistema de Vistoria</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-car-burst"></i> Pilkington
            </div>
            <nav class="sidebar-nav">
                <a href="<?= BASE_URL ?>/dashboard" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="<?= BASE_URL ?>/vistorias" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/vistorias') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-clipboard-list"></i> Vistorias
                </a>
                <?php if (isset($_SESSION['user_profile']) && in_array($_SESSION['user_profile'], ['Administrador', 'Gerente', 'Supervisor'])): ?>
                <a href="<?= BASE_URL ?>/veiculos" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/veiculos') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-car"></i> Veículos
                </a>
                <a href="<?= BASE_URL ?>/itens" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/itens') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-tools"></i> Itens de Reparo
                </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_profile']) && in_array($_SESSION['user_profile'], ['Administrador', 'Gerente'])): ?>
                <a href="<?= BASE_URL ?>/usuarios" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/usuarios') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i> Usuários
                </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/logout" class="nav-link" style="margin-top: auto; background: rgba(220, 53, 69, 0.2);">
                    <i class="fa-solid fa-sign-out-alt"></i> Sair
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <h2 class="page-title"><?= isset($pageTitle) ? $pageTitle : 'Dashboard' ?></h2>
                <div class="user-profile">
                    <span><i class="fa-solid fa-user-circle"></i> <?= $_SESSION['user_name'] ?? 'Usuário' ?></span>
                </div>
            </header>
