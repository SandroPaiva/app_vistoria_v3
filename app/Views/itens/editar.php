<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Editar Item de Serviço</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Preencha os dados do catálogo de serviço oferecido.</p>
    </div>

    <form action="<?= BASE_URL ?>/itens/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
        
        <div class="form-group">
            <label class="form-label" for="tipo_reparo">Tipo de Serviço *</label>
            <select name="tipo_reparo" id="tipo_reparo" class="form-control" required>
                <option value="">Selecione...</option>
                <option value="Reparo de rachaduras" <?= $item['tipo_reparo'] === 'Reparo de rachaduras' ? 'selected' : '' ?>>Reparo de rachaduras</option>
                <option value="Troca completa" <?= $item['tipo_reparo'] === 'Troca completa' ? 'selected' : '' ?>>Troca completa</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="classificacao_vidro">Classificação do Vidro *</label>
            <select name="classificacao_vidro" id="classificacao_vidro" class="form-control" required>
                <option value="">Selecione...</option>
                <option value="Para-brisa" <?= $item['classificacao_vidro'] === 'Para-brisa' ? 'selected' : '' ?>>Para-brisa</option>
                <option value="Porta Dianteira Esquerda" <?= $item['classificacao_vidro'] === 'Porta Dianteira Esquerda' ? 'selected' : '' ?>>Porta Dianteira Esquerda</option>
                <option value="Porta Dianteira Direita" <?= $item['classificacao_vidro'] === 'Porta Dianteira Direita' ? 'selected' : '' ?>>Porta Dianteira Direita</option>
                <option value="Porta Traseira Esquerda" <?= $item['classificacao_vidro'] === 'Porta Traseira Esquerda' ? 'selected' : '' ?>>Porta Traseira Esquerda</option>
                <option value="Porta Traseira Direita" <?= $item['classificacao_vidro'] === 'Porta Traseira Direita' ? 'selected' : '' ?>>Porta Traseira Direita</option>
                <option value="Vigia" <?= $item['classificacao_vidro'] === 'Vigia' ? 'selected' : '' ?>>Vigia</option>
                <option value="Lanternas" <?= $item['classificacao_vidro'] === 'Lanternas' ? 'selected' : '' ?>>Lanternas</option>
                <option value="Faróis" <?= $item['classificacao_vidro'] === 'Faróis' ? 'selected' : '' ?>>Faróis</option>
                <option value="Espelhos" <?= $item['classificacao_vidro'] === 'Espelhos' ? 'selected' : '' ?>>Espelhos</option>
                <option value="Outros" <?= $item['classificacao_vidro'] === 'Outros' ? 'selected' : '' ?>>Outros</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="especificacao_outros">Especificação (caso selecione "Outros")</label>
            <input type="text" name="especificacao_outros" id="especificacao_outros" class="form-control" value="<?= htmlspecialchars($item['especificacao_outros'] ?? '') ?>" placeholder="Descreva o vidro caso não esteja na lista">
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Atualizar Item</button>
            <a href="<?= BASE_URL ?>/itens" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
