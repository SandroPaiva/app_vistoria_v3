<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Lista de Usuários</h3>
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nome_completo']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['login']) ?></td>
                    <td><span class="badge" style="background: var(--color-dark-mid);"><?= $u['perfil_acesso'] ?></span></td>
                    <td>
                        <button class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
