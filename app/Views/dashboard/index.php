<div class="dashboard-grid">
    <div class="stat-card">
        <h3>Veículos Cadastrados</h3>
        <div class="value text-primary"><?= $veiculosCount ?></div>
        <i class="fa-solid fa-car icon"></i>
    </div>
    <div class="stat-card">
        <h3>Vistorias em Andamento</h3>
        <div class="value" style="color: var(--color-warning);"><?= $vistoriasAndamento ?></div>
        <i class="fa-solid fa-spinner icon" style="color: var(--color-warning);"></i>
    </div>
    <div class="stat-card">
        <h3>Vistorias Concluídas</h3>
        <div class="value" style="color: var(--color-success);"><?= $vistoriasConcluidas ?></div>
        <i class="fa-solid fa-check-circle icon" style="color: var(--color-success);"></i>
    </div>
    <div class="stat-card">
        <h3>Vistorias Canceladas</h3>
        <div class="value" style="color: var(--color-danger);"><?= $vistoriasCanceladas ?></div>
        <i class="fa-solid fa-times-circle icon" style="color: var(--color-danger);"></i>
    </div>
</div>

<div class="panel">
    <h3 style="color: var(--color-primary-dark); margin-bottom: 1rem;">Bem-vindo ao Sistema de Vistoria, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>!</h3>
    <p>Utilize o menu lateral para navegar entre as opções disponíveis para o seu perfil de acesso (<strong><?= htmlspecialchars($_SESSION['user_profile']) ?></strong>).</p>
</div>
