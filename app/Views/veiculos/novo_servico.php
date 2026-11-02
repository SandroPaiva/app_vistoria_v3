<div class="panel">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-rotate-right" style="color: var(--color-primary);"></i> Registrar Novo Serviço / Refazer
            </h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">
                Veículo: <strong><?= htmlspecialchars($veiculo['placa']) ?></strong> (<?= htmlspecialchars($veiculo['fabricante'] . ' ' . $veiculo['modelo']) ?>) | Cliente: <strong><?= htmlspecialchars($veiculo['nome_proprietario'] ?? 'Não informado') ?></strong>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/veiculos/visualizar/<?= $veiculo['id'] ?>" class="btn btn-secondary" style="padding: 8px 16px; font-size: 12px;">
            <i class="fa-solid fa-arrow-left"></i> Voltar ao Veículo
        </a>
    </div>

    <!-- Alerta de Política Operacional -->
    <div style="background: var(--color-surface); padding: 15px 20px; border-radius: var(--radius-md); border-left: 4px solid var(--color-warning); margin-bottom: 25px; font-size: 13px;">
        <i class="fa-solid fa-triangle-exclamation" style="color: var(--color-warning); margin-right: 6px;"></i>
        <strong>Histórico Obrigatório:</strong> Este veículo já possui <?= count($historico) ?> serviço(s) anterior(es). Todo novo atendimento requer a seleção formal do <strong>Motivo</strong> e a inserção de uma <strong>Observação Complementar detalhada</strong>, que ficará gravada permanentemente no dossiê do veículo e no relatório técnico.
    </div>

    <form action="<?= BASE_URL ?>/veiculos/novo-servico" method="POST">
        <input type="hidden" name="veiculo_id" value="<?= $veiculo['id'] ?>">
        <input type="hidden" name="veiculo_placa" value="<?= htmlspecialchars($veiculo['placa']) ?>">
        <input type="hidden" name="veiculo_tipo" value="<?= htmlspecialchars($veiculo['tipo_veiculo']) ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="motivo_servico">Motivo do Atendimento *</label>
                <select name="motivo_servico" id="motivo_servico" class="form-control" required style="font-weight: 600;">
                    <option value="">Selecione o motivo da solicitação...</option>
                    <option value="Novo Serviço">Novo Serviço (Nova avaria, troca de outro vidro ou serviço complementar)</option>
                    <option value="Refazer">Refazer (Retrabalho, garantia, ajuste ou correção de serviço anterior)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="tecnico_id">Técnico Responsável *</label>
                <select name="tecnico_id" id="tecnico_id" class="form-control" required>
                    <option value="">Atribua a um técnico...</option>
                    <?php foreach ($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>">
                            <?= htmlspecialchars($t['nome_completo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="item_reparo_id">Item de Serviço Alvo *</label>
                <select name="item_reparo_id" id="item_reparo_id" class="form-control" required>
                    <option value="">Selecione o item de serviço a ser executado...</option>
                    <?php foreach ($itens as $i): ?>
                        <option value="<?= $i['id'] ?>" <?= $veiculo['item_reparo_id'] == $i['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($i['tipo_reparo'] . ' - ' . $i['classificacao_vidro']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="data_agendamento">Data e Horário de Agendamento (Opcional)</label>
                <input type="datetime-local" name="data_agendamento" id="data_agendamento" class="form-control">
                <small style="display: block; margin-top: 4px; color: var(--color-mid);">Se preenchido, o status será "Agendado". Se deixado em branco, inicia imediatamente como "Em Andamento".</small>
            </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <label class="form-label" for="observacao_motivo">Observação Complementar do Motivo (Obrigatória) *</label>
            <textarea name="observacao_motivo" id="observacao_motivo" class="form-control" rows="4" required placeholder="Explique os detalhes do novo atendimento ou a razão do retrabalho (ex: Nova trinca no para-brisa após impacto na rodovia; Retrabalho de vedação sob garantia OS #123)..."></textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Confirmar e Registrar no Histórico</button>
            <a href="<?= BASE_URL ?>/veiculos/visualizar/<?= $veiculo['id'] ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
