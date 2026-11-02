<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin: 0;">Lista de Usuários</h3>
            <p style="color: var(--color-mid); font-size: 13px; margin-top: 4px;">Gerencie o acesso, perfis e status operacional dos colaboradores.</p>
        </div>
        <a href="<?= BASE_URL ?>/usuarios/novo" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo Usuário</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Email</th>
                    <th>Login</th>
                    <th>Perfil</th>
                    <th>Status</th>
                    <th>Data Alteração</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr><td colspan="8" style="text-align: center;">Nenhum usuário cadastrado.</td></tr>
                <?php endif; ?>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><strong><?= htmlspecialchars($u['nome_completo']) ?></strong></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['login']) ?></td>
                    <td><span class="badge" style="background: var(--color-dark-mid);"><?= $u['perfil_acesso'] ?></span></td>
                    <td>
                        <?php if ($u['ativo'] == 1): ?>
                            <span class="status-circle status-active" title="Ativo" data-status="ativo"><i class="fa-solid fa-check"></i></span>
                        <?php else: ?>
                            <span class="status-circle status-inactive" title="Inativo" data-status="inativo"><i class="fa-solid fa-xmark"></i></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= !empty($u['data_alteracao']) ? date('d/m/Y H:i', strtotime($u['data_alteracao'])) : '-' ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/usuarios/editar/<?= $u['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;" title="Editar"><i class="fa-solid fa-edit"></i></a>
                        <?php if ($u['ativo'] == 1): ?>
                            <a href="<?= BASE_URL ?>/usuarios/desativar/<?= $u['id'] ?>" class="btn btn-danger" style="padding: 4px 10px; font-size: 11px;" onclick="return confirm('Deseja realmente desativar este usuário?')" title="Desativar"><i class="fa-solid fa-ban"></i></a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/usuarios/ativar/<?= $u['id'] ?>" class="btn btn-reativar" style="padding: 4px 10px; font-size: 11px;" onclick="return confirm('Deseja reativar este usuário?')" title="Reativar"><i class="fa-solid fa-check"></i> Reativar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
