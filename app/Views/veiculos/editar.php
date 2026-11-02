<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="margin: 0;">Editar Veículo</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Atualize os dados cadastrais do veículo e reprograme agendamentos.</p>
    </div>

    <form action="<?= BASE_URL ?>/veiculos/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($veiculo['id']) ?>">
        
        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-bottom: 18px; color: var(--color-primary-dark);">
            <i class="fa-solid fa-car"></i> Dados do Veículo e Proprietário
        </h4>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="placa">Placa *</label>
                <input type="text" name="placa" id="placa" class="form-control" value="<?= htmlspecialchars($veiculo['placa']) ?>" required style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label" for="chassi">Chassi</label>
                <input type="text" name="chassi" id="chassi" class="form-control" value="<?= htmlspecialchars($veiculo['chassi'] ?? '') ?>" style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label" for="fabricante">Fabricante (Marca)</label>
                <input type="text" name="fabricante" id="fabricante" class="form-control" value="<?= htmlspecialchars($veiculo['fabricante'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="<?= htmlspecialchars($veiculo['modelo'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="ano_fabricacao">Ano de Fabricação</label>
                <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="form-control" value="<?= htmlspecialchars($veiculo['ano_fabricacao'] ?? '') ?>" min="1900" max="2100">
            </div>

            <div class="form-group">
                <label class="form-label" for="tipo_veiculo">Tipo de Veículo *</label>
                <select name="tipo_veiculo" id="tipo_veiculo" class="form-control" required>
                    <option value="Carro" <?= $veiculo['tipo_veiculo'] === 'Carro' ? 'selected' : '' ?>>Carro</option>
                    <option value="Caminhão" <?= $veiculo['tipo_veiculo'] === 'Caminhão' ? 'selected' : '' ?>>Caminhão</option>
                    <option value="Mini Van" <?= $veiculo['tipo_veiculo'] === 'Mini Van' ? 'selected' : '' ?>>Mini Van</option>
                    <option value="Micro-ônibus" <?= $veiculo['tipo_veiculo'] === 'Micro-ônibus' ? 'selected' : '' ?>>Micro-ônibus</option>
                    <option value="Outros" <?= $veiculo['tipo_veiculo'] === 'Outros' ? 'selected' : '' ?>>Outros</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="nome_proprietario">Nome do Proprietário</label>
                <input type="text" name="nome_proprietario" id="nome_proprietario" class="form-control" value="<?= htmlspecialchars($veiculo['nome_proprietario'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="telefone_proprietario">Telefone do Proprietário</label>
                <input type="text" name="telefone_proprietario" id="telefone_proprietario" class="form-control" value="<?= htmlspecialchars($veiculo['telefone_proprietario'] ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 1rem;">
            <div class="form-group">
                <label class="form-label" for="item_reparo_id">Item de Serviço Alvo</label>
                <select name="item_reparo_id" id="item_reparo_id" class="form-control">
                    <option value="">Selecione um item (ou cadastre depois)...</option>
                    <?php foreach ($itens as $i): ?>
                        <option value="<?= $i['id'] ?>" <?= $veiculo['item_reparo_id'] == $i['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($i['tipo_reparo'] . ' - ' . $i['classificacao_vidro']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="ativo">Status *</label>
                <select name="ativo" id="ativo" class="form-control" required>
                    <option value="1" <?= $veiculo['ativo'] == 1 ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= $veiculo['ativo'] == 0 ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <!-- Seção de Agendamento -->
        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-top: 30px; margin-bottom: 18px; color: var(--color-primary-dark);">
            <i class="fa-regular fa-calendar-check"></i> Programação de Atendimento (Dia e Hora)
        </h4>
        <div style="background: var(--color-surface); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--color-border); margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" for="data_agendamento">Data e Horário do Agendamento</label>
                    <?php 
                        $valAgendamento = !empty($veiculo['data_agendamento']) ? date('Y-m-d\TH:i', strtotime($veiculo['data_agendamento'])) : '';
                    ?>
                    <input type="datetime-local" name="data_agendamento" id="data_agendamento" class="form-control" value="<?= $valAgendamento ?>">
                </div>

                <div class="form-group" style="margin: 0;">
                    <label class="form-label" for="tecnico_agendado_id">Técnico Designado</label>
                    <select name="tecnico_agendado_id" id="tecnico_agendado_id" class="form-control">
                        <option value="">Selecione o técnico responsável...</option>
                        <?php foreach ($tecnicos as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= ($veiculo['tecnico_agendado_id'] ?? null) == $t['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['nome_completo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Atualizar Veículo</button>
            <a href="<?= BASE_URL ?>/veiculos" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
