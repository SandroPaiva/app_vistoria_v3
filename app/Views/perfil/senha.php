<div style="max-width: 600px; margin: 0 auto;">
    
    <div class="panel" style="border-top: 4px solid var(--color-primary); box-shadow: var(--shadow-md);">
        
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--color-border); padding-bottom: 1rem; margin-bottom: 1.5rem;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-key text-primary"></i> Trocar Senha de Acesso
                </h3>
                <small style="color: var(--color-mid); font-size: 12px; margin-top: 4px; display: block;">
                    Usuário: <strong><?= htmlspecialchars($user['nome_completo'] ?? $_SESSION['user_name']) ?></strong> (<?= htmlspecialchars($user['login'] ?? '') ?>)
                </small>
            </div>
            <a href="<?= BASE_URL ?>/perfil" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px;">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Perfil
            </a>
        </div>

        <div style="background: rgba(97, 206, 112, 0.08); border-left: 4px solid var(--color-primary); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 13px; color: var(--color-dark-mid);">
            <i class="fa-solid fa-shield-halved text-primary"></i> <strong>Regras de Segurança:</strong>
            <ul style="margin: 6px 0 0 18px; padding: 0; font-size: 12px; color: var(--color-mid);">
                <li>É obrigatório informar sua <strong>senha atual</strong> para autorizar a modificação.</li>
                <li>A nova senha deve ter no mínimo <strong>6 caracteres</strong>.</li>
                <li>A nova senha deve ser inserida <strong>duas vezes</strong> exatamente iguais para confirmação.</li>
            </ul>
        </div>

        <form action="<?= BASE_URL ?>/perfil/senha" method="POST" id="form-trocar-senha">
            
            <!-- Campo: Senha Atual -->
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" for="senha_atual" style="font-weight: 600;">
                    Senha Atual <span class="text-danger">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" id="senha_atual" name="senha_atual" class="form-control" required placeholder="Digite sua senha atual" autofocus style="padding-right: 40px;">
                    <button type="button" class="btn-toggle-pass" onclick="togglePasswordVisibility('senha_atual', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-mid); cursor: pointer; padding: 4px 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Campo: Nova Senha -->
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" for="nova_senha" style="font-weight: 600;">
                    Nova Senha <span class="text-danger">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required minlength="6" placeholder="Digite a nova senha (mínimo 6 caracteres)" style="padding-right: 40px;">
                    <button type="button" class="btn-toggle-pass" onclick="togglePasswordVisibility('nova_senha', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-mid); cursor: pointer; padding: 4px 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Campo: Confirmação da Nova Senha -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" for="confirmar_senha" style="font-weight: 600;">
                    Confirmar Nova Senha <span class="text-danger">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required minlength="6" placeholder="Repita a nova senha para confirmação" style="padding-right: 40px;">
                    <button type="button" class="btn-toggle-pass" onclick="togglePasswordVisibility('confirmar_senha', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-mid); cursor: pointer; padding: 4px 6px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div id="senha-match-indicator" style="font-size: 11px; margin-top: 4px; display: none;"></div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 1.25rem;">
                <a href="<?= BASE_URL ?>/perfil" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                    <i class="fa-solid fa-check"></i> Salvar Nova Senha
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function togglePasswordVisibility(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-solid fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-solid fa-eye';
    }
}

// Validação em tempo real de coincidência de senhas
document.addEventListener('DOMContentLoaded', function () {
    const novaSenha = document.getElementById('nova_senha');
    const confirmaSenha = document.getElementById('confirmar_senha');
    const indicator = document.getElementById('senha-match-indicator');
    const form = document.getElementById('form-trocar-senha');

    function checkMatch() {
        if (!confirmaSenha.value) {
            indicator.style.display = 'none';
            return;
        }

        indicator.style.display = 'block';
        if (novaSenha.value === confirmaSenha.value) {
            indicator.innerHTML = '<span class="text-success"><i class="fa-solid fa-check-circle"></i> As novas senhas coincidem.</span>';
        } else {
            indicator.innerHTML = '<span class="text-danger"><i class="fa-solid fa-times-circle"></i> As novas senhas não conferem.</span>';
        }
    }

    novaSenha.addEventListener('input', checkMatch);
    confirmaSenha.addEventListener('input', checkMatch);

    form.addEventListener('submit', function (e) {
        if (novaSenha.value !== confirmaSenha.value) {
            e.preventDefault();
            alert('A nova senha e a confirmação de senha não conferem. Por favor, verifique.');
            confirmaSenha.focus();
        }
    });
});
</script>
