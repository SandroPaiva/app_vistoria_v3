<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilkington - Sistema de Serviços</title>
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
                    <i class="fa-solid fa-clipboard-list"></i> Serviços
                </a>
                <?php if (isset($_SESSION['user_profile']) && in_array($_SESSION['user_profile'], ['Administrador', 'Gerente', 'Supervisor'])): ?>
                <a href="<?= BASE_URL ?>/veiculos" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/veiculos') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-car"></i> Veículos
                </a>
                <a href="<?= BASE_URL ?>/itens" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/itens') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-tools"></i> Itens de Serviço
                </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_profile']) && in_array($_SESSION['user_profile'], ['Administrador', 'Gerente'])): ?>
                <a href="<?= BASE_URL ?>/usuarios" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/usuarios') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i> Usuários
                </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/logout" class="nav-link logout-link" style="margin-top: auto;">
                    <i class="fa-solid fa-sign-out-alt"></i> Sair
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <h2 class="page-title"><?= isset($pageTitle) ? $pageTitle : 'Dashboard' ?></h2>
                
                <!-- Menu Dropdown do Usuário Logado -->
                <div class="user-menu-container" id="userMenuContainer">
                    <button type="button" class="user-profile-trigger" id="userMenuTrigger" aria-expanded="false" aria-haspopup="true" title="Opções da Conta">
                        <i class="fa-solid fa-circle-user avatar-icon"></i>
                        <span class="user-display-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuário') ?></span>
                        <i class="fa-solid fa-chevron-down chevron-icon"></i>
                    </button>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-header">
                            <strong class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuário') ?></strong>
                            <small class="user-role"><i class="fa-solid fa-id-badge"></i> <?= htmlspecialchars($_SESSION['user_profile'] ?? 'Operador') ?></small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="<?= BASE_URL ?>/perfil" class="dropdown-item">
                            <i class="fa-solid fa-id-badge"></i>
                            <span>Ver Perfil</span>
                        </a>
                        <a href="<?= BASE_URL ?>/perfil/senha" class="dropdown-item">
                            <i class="fa-solid fa-key"></i>
                            <span>Trocar Senha</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item item-logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Alertas Globais (Flash Messages) -->
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert alert-success" style="background: rgba(46, 125, 50, 0.12); color: var(--color-success); padding: 12px 18px; border-radius: var(--radius-md); border-left: 4px solid var(--color-success); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; font-size: 13px; font-weight: 500;">
                    <div><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($_SESSION['flash_success']) ?></div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 16px;">&times;</button>
                </div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger" style="background: rgba(211, 47, 47, 0.12); color: var(--color-danger); padding: 12px 18px; border-radius: var(--radius-md); border-left: 4px solid var(--color-danger); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; font-size: 13px; font-weight: 500;">
                    <div><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['flash_error']) ?></div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 16px;">&times;</button>
                </div>
                <?php unset($_SESSION['flash_error']); ?>
            <?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('userMenuTrigger');
    const menu = document.getElementById('userDropdownMenu');

    if (trigger && menu) {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = menu.classList.contains('show');
            if (isOpen) {
                menu.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
            } else {
                menu.classList.add('show');
                trigger.setAttribute('aria-expanded', 'true');
            }
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                menu.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menu.classList.contains('show')) {
                menu.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>
