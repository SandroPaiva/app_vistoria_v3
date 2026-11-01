<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Editar Usuário</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Atualize os dados do operador ou técnico.</p>
    </div>

    <form action="<?= BASE_URL ?>/usuarios/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
        
        <div class="form-group">
            <label class="form-label" for="nome_completo">Nome Completo *</label>
            <input type="text" name="nome_completo" id="nome_completo" class="form-control" value="<?= htmlspecialchars($usuario['nome_completo']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">E-mail *</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="login">Login de Acesso *</label>
                <input type="text" name="login" id="login" class="form-control" value="<?= htmlspecialchars($usuario['login']) ?>" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label" for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Deixe em branco para não alterar" autocomplete="new-password">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="perfil_acesso">Perfil de Acesso *</label>
                <select name="perfil_acesso" id="perfil_acesso" class="form-control" required>
                    <option value="">Selecione o nível de permissão...</option>
                    <?php if ($_SESSION['user_profile'] === 'Administrador'): ?>
                        <option value="Administrador" <?= $usuario['perfil_acesso'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                        <option value="Gerente" <?= $usuario['perfil_acesso'] === 'Gerente' ? 'selected' : '' ?>>Gerente</option>
                    <?php endif; ?>
                    <option value="Supervisor" <?= $usuario['perfil_acesso'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="Técnico" <?= $usuario['perfil_acesso'] === 'Técnico' ? 'selected' : '' ?>>Técnico</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="ativo">Status do Usuário *</label>
                <select name="ativo" id="ativo" class="form-control" required>
                    <option value="1" <?= $usuario['ativo'] == 1 ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= $usuario['ativo'] == 0 ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Atualizar Usuário</button>
            <a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
