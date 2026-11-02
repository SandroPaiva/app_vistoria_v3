<div style="max-width: 900px; margin: 0 auto;">
    
    <!-- Header com Resumo do Perfil -->
    <div class="panel" style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; border-top: 4px solid var(--color-primary);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: var(--shadow-sm);">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 20px;"><?= htmlspecialchars($user['nome_completo']) ?></h2>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                    <span class="badge" style="background: var(--color-primary-dark); font-size: 11px;">
                        <i class="fa-solid fa-shield-halved"></i> Perfil: <?= htmlspecialchars($user['perfil_acesso']) ?>
                    </span>
                    <?php if (!empty($user['ativo'])): ?>
                        <span class="status-circle status-active" title="Ativo" data-status="ativo"><i class="fa-solid fa-check"></i></span>
                    <?php else: ?>
                        <span class="status-circle status-inactive" title="Inativo" data-status="inativo"><i class="fa-solid fa-xmark"></i></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/perfil/senha" class="btn btn-primary" style="padding: 10px 18px; font-size: 13px;">
                <i class="fa-solid fa-key"></i> Trocar Minha Senha
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Formulário: Alterar Nome Completo -->
        <div class="panel">
            <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 16px; border-bottom: 1px solid var(--color-border); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-pen text-primary"></i> Alterar Meu Nome
            </h3>
            <p style="font-size: 13px; color: var(--color-mid); margin-bottom: 1.25rem;">
                Atualize como seu nome é exibido no cabeçalho do sistema, nas escalas de serviço e nos laudos técnicos de vistoria.
            </p>

            <form action="<?= BASE_URL ?>/perfil/nome" method="POST">
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="nome_completo" style="font-weight: 600;">Nome Completo</label>
                    <input type="text" id="nome_completo" name="nome_completo" class="form-control" value="<?= htmlspecialchars($user['nome_completo']) ?>" required minlength="3" placeholder="Seu nome completo">
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar Novo Nome
                    </button>
                </div>
            </form>
        </div>

        <!-- Painel: Informações Cadastrais Completas -->
        <div class="panel">
            <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 16px; border-bottom: 1px solid var(--color-border); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-id-card text-primary"></i> Dados da Conta
            </h3>

            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--color-border); padding-bottom: 8px;">
                    <span style="color: var(--color-mid); font-weight: 500;">Login de Acesso:</span>
                    <strong style="color: var(--color-dark);"><?= htmlspecialchars($user['login']) ?></strong>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--color-border); padding-bottom: 8px;">
                    <span style="color: var(--color-mid); font-weight: 500;">E-mail:</span>
                    <strong style="color: var(--color-dark);"><?= htmlspecialchars($user['email']) ?></strong>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--color-border); padding-bottom: 8px;">
                    <span style="color: var(--color-mid); font-weight: 500;">Nível de Acesso:</span>
                    <span>
                        <span class="badge" style="background: var(--color-primary);"><?= htmlspecialchars($user['perfil_acesso']) ?></span>
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--color-border); padding-bottom: 8px;">
                    <span style="color: var(--color-mid); font-weight: 500;">Status do Usuário:</span>
                    <span>
                        <?= !empty($user['ativo']) ? '<span class="status-circle status-active" title="Ativo"><i class="fa-solid fa-check"></i></span>' : '<span class="status-circle status-inactive" title="Inativo"><i class="fa-solid fa-xmark"></i></span>' ?>
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--color-border); padding-bottom: 8px;">
                    <span style="color: var(--color-mid); font-weight: 500;">Data de Cadastro:</span>
                    <span style="color: var(--color-dark-mid);"><?= !empty($user['data_criacao']) ? date('d/m/Y H:i', strtotime($user['data_criacao'])) : '-' ?></span>
                </div>

                <div style="display: flex; justify-content: space-between; padding-bottom: 4px;">
                    <span style="color: var(--color-mid); font-weight: 500;">Última Alteração:</span>
                    <span style="color: var(--color-dark-mid);"><?= !empty($user['data_alteracao']) ? date('d/m/Y H:i', strtotime($user['data_alteracao'])) : '-' ?></span>
                </div>
            </div>

            <div style="margin-top: 1.25rem; background: var(--color-surface); padding: 10px 14px; border-radius: var(--radius-sm); border-left: 3px solid var(--color-primary); font-size: 11px; color: var(--color-mid);">
                <i class="fa-solid fa-lock"></i> Para alterar e-mail ou nível de acesso, contate o administrador do sistema.
            </div>
        </div>

    </div>

</div>
