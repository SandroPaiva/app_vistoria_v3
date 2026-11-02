<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="margin: 0;">Cadastrar Novo Veículo</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Preencha os dados do veículo, associe a um item e agende o atendimento se desejar.</p>
    </div>

    <form action="<?= BASE_URL ?>/veiculos/store" method="POST">
        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-bottom: 18px; color: var(--color-primary-dark);">
            <i class="fa-solid fa-car"></i> Dados do Veículo e Proprietário
        </h4>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="placa">Placa *</label>
                <input type="text" name="placa" id="placa" class="form-control" required style="text-transform: uppercase;" placeholder="Ex: ABC1D23">
            </div>

            <div class="form-group">
                <label class="form-label" for="chassi">Chassi</label>
                <input type="text" name="chassi" id="chassi" class="form-control" style="text-transform: uppercase;" placeholder="Número do Chassi">
            </div>

            <div class="form-group">
                <label class="form-label" for="fabricante">Fabricante (Marca)</label>
                <input type="text" name="fabricante" id="fabricante" class="form-control" placeholder="Ex: Volkswagen, Fiat, Ford">
            </div>

            <div class="form-group">
                <label class="form-label" for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ex: Gol 1.0, Uno, Corolla">
            </div>

            <div class="form-group">
                <label class="form-label" for="ano_fabricacao">Ano de Fabricação</label>
                <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="form-control" min="1900" max="2100" placeholder="Ex: 2022">
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
                <input type="text" name="nome_proprietario" id="nome_proprietario" class="form-control" placeholder="Nome completo do cliente">
            </div>

            <div class="form-group">
                <label class="form-label" for="telefone_proprietario">Telefone do Proprietário</label>
                <input type="text" name="telefone_proprietario" id="telefone_proprietario" class="form-control" placeholder="(00) 00000-0000">
            </div>
        </div>

        <div class="form-group" style="margin-top: 1rem;">
            <label class="form-label" for="item_reparo_id">Item de Serviço Alvo (Catálogo Pilkington)</label>
            <select name="item_reparo_id" id="item_reparo_id" class="form-control">
                <option value="">Selecione um item (ou cadastre depois)...</option>
                <?php foreach ($itens as $i): ?>
                    <option value="<?= $i['id'] ?>">
                        <?= htmlspecialchars($i['tipo_reparo'] . ' - ' . $i['classificacao_vidro']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Seção de Agendamento de Serviço -->
        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-top: 30px; margin-bottom: 18px; color: var(--color-primary-dark);">
            <i class="fa-regular fa-calendar-plus"></i> Agendamento de Serviço (Dia e Hora)
        </h4>
        <div style="background: var(--color-surface); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--color-border); margin-bottom: 20px;">
            <p style="font-size: 13px; color: var(--color-mid); margin-bottom: 15px;">
                Deseja programar um atendimento para este veículo agora? Ao preencher a data e técnico, um agendamento será criado automaticamente.
            </p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" for="data_agendamento">Data e Horário do Agendamento</label>
                    <input type="datetime-local" name="data_agendamento" id="data_agendamento" class="form-control">
                </div>

                <div class="form-group" style="margin: 0;">
                    <label class="form-label" for="tecnico_agendado_id">Técnico Designado</label>
                    <select name="tecnico_agendado_id" id="tecnico_agendado_id" class="form-control">
                        <option value="">Selecione o técnico responsável...</option>
                        <?php foreach ($tecnicos as $t): ?>
                            <option value="<?= $t['id'] ?>">
                                <?= htmlspecialchars($t['nome_completo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Salvar Veículo</button>
            <a href="<?= BASE_URL ?>/veiculos" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
