<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Cadastrar Novo Item</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Preencha os dados do catálogo de reparo oferecido.</p>
    </div>

    <form action="<?= BASE_URL ?>/itens/store" method="POST">
        <div class="form-group">
            <label class="form-label" for="tipo_reparo">Tipo de Reparo *</label>
            <select name="tipo_reparo" id="tipo_reparo" class="form-control" required>
                <option value="">Selecione...</option>
                <option value="Reparo de rachaduras">Reparo de rachaduras</option>
                <option value="Troca completa">Troca completa</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="classificacao_vidro">Classificação do Vidro *</label>
            <select name="classificacao_vidro" id="classificacao_vidro" class="form-control" required>
                <option value="">Selecione...</option>
                <option value="Para-brisa">Para-brisa</option>
                <option value="Porta Dianteira Esquerda">Porta Dianteira Esquerda</option>
                <option value="Porta Dianteira Direita">Porta Dianteira Direita</option>
                <option value="Porta Traseira Esquerda">Porta Traseira Esquerda</option>
                <option value="Porta Traseira Direita">Porta Traseira Direita</option>
                <option value="Vigia">Vigia</option>
                <option value="Lanternas">Lanternas</option>
                <option value="Faróis">Faróis</option>
                <option value="Espelhos">Espelhos</option>
                <option value="Outros">Outros</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="especificacao_outros">Especificação (caso selecione "Outros")</label>
            <input type="text" name="especificacao_outros" id="especificacao_outros" class="form-control" placeholder="Descreva o vidro caso não esteja na lista">
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Salvar Item</button>
            <a href="<?= BASE_URL ?>/itens" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
