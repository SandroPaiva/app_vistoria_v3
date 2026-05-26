<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Cadastrar Novo Usuário</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Preencha os dados do novo operador ou técnico.</p>
    </div>

    <form action="<?= BASE_URL ?>/usuarios/store" method="POST">
        <div class="form-group">
            <label class="form-label" for="nome_completo">Nome Completo *</label>
            <input type="text" name="nome_completo" id="nome_completo" class="form-control" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">E-mail *</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="login">Login de Acesso *</label>
                <input type="text" name="login" id="login" class="form-control" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label" for="senha">Senha *</label>
                <input type="password" name="senha" id="senha" class="form-control" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="perfil_acesso">Perfil de Acesso *</label>
            <select name="perfil_acesso" id="perfil_acesso" class="form-control" required>
                <option value="">Selecione o nível de permissão...</option>
                <?php if ($_SESSION['user_profile'] === 'Administrador'): ?>
                    <option value="Administrador">Administrador</option>
                    <option value="Gerente">Gerente</option>
                <?php endif; ?>
                <option value="Supervisor">Supervisor</option>
                <option value="Técnico">Técnico</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Salvar Usuário</button>
            <a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
