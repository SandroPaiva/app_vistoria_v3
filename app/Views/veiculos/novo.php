<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Cadastrar Novo Veículo</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Preencha os dados do veículo e associe a um item de reparo.</p>
    </div>

    <form action="<?= BASE_URL ?>/veiculos/store" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="placa">Placa *</label>
                <input type="text" name="placa" id="placa" class="form-control" required style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label" for="chassi">Chassi</label>
                <input type="text" name="chassi" id="chassi" class="form-control" style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label" for="fabricante">Fabricante (Marca)</label>
                <input type="text" name="fabricante" id="fabricante" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="ano_fabricacao">Ano de Fabricação</label>
                <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="form-control" min="1900" max="2100">
            </div>

            <div class="form-group">
                <label class="form-label" for="tipo_veiculo">Tipo de Veículo *</label>
                <select name="tipo_veiculo" id="tipo_veiculo" class="form-control" required>
                    <option value="Carro">Carro</option>
                    <option value="Caminhão">Caminhão</option>
                    <option value="Mini Van">Mini Van</option>
                    <option value="Micro-ônibus">Micro-ônibus</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="nome_proprietario">Nome do Proprietário</label>
                <input type="text" name="nome_proprietario" id="nome_proprietario" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="telefone_proprietario">Telefone do Proprietário</label>
                <input type="text" name="telefone_proprietario" id="telefone_proprietario" class="form-control">
            </div>
        </div>

        <div class="form-group" style="margin-top: 1rem;">
            <label class="form-label" for="item_reparo_id">Item de Reparo (Opcional)</label>
            <select name="item_reparo_id" id="item_reparo_id" class="form-control">
                <option value="">Selecione um item (ou cadastre depois)...</option>
                <?php foreach ($itens as $i): ?>
                    <option value="<?= $i['id'] ?>">
                        <?= htmlspecialchars($i['tipo_reparo'] . ' - ' . $i['classificacao_vidro']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Salvar Veículo</button>
            <a href="<?= BASE_URL ?>/veiculos" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
