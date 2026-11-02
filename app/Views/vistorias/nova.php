<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="margin: 0;">Iniciar Novo Serviço</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Selecione o veículo e o técnico responsável para iniciar o processo de serviço.</p>
    </div>

    <div style="background: var(--color-surface); padding: 12px 18px; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary); margin-bottom: 20px; font-size: 13px;">
        <i class="fa-solid fa-circle-info" style="color: var(--color-primary); margin-right: 6px;"></i>
        <strong>Nota:</strong> Esta lista exibe apenas veículos sem nenhum serviço anterior registrado. Caso deseje cadastrar um novo atendimento ou retrabalho para um veículo que já possui histórico, utilize a opção <strong>"Novo Serviço / Refazer"</strong> no menu de <a href="<?= BASE_URL ?>/veiculos" style="color: var(--color-primary); font-weight: bold;">Veículos</a>.
    </div>

    <?php if (empty($veiculos)): ?>
        <div style="background: #FFF8E1; border: 1px solid #FFE082; padding: 20px; border-radius: var(--radius-md); text-align: center; color: #8D6E63; margin-bottom: 20px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; display: block; margin-bottom: 8px; color: #FFA000;"></i>
            <strong>Nenhum veículo novo disponível para primeiro serviço.</strong>
            <p style="margin: 8px 0 0 0; font-size: 13px;">Todos os veículos cadastrados já possuem atendimentos em andamento, concluídos ou cancelados. <a href="<?= BASE_URL ?>/veiculos/novo" style="color: var(--color-primary); font-weight: bold;">Cadastre um novo veículo</a> ou abra um novo serviço pelo histórico do veículo existente.</p>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/vistorias/store" method="POST">
        <div class="form-group">
            <label class="form-label" for="veiculo_id">Veículo Alvo (Sem serviços registrados) *</label>
            <select name="veiculo_id" id="veiculo_id" class="form-control" required <?= empty($veiculos) ? 'disabled' : '' ?>>
                <option value="">Selecione o veículo pela placa ou modelo...</option>
                <?php foreach ($veiculos as $v): ?>
                    <option value="<?= $v['id'] ?>">
                        <?= htmlspecialchars($v['placa'] . ' - ' . $v['fabricante'] . ' ' . $v['modelo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small style="display: block; margin-top: 5px; color: var(--color-mid);">Não encontrou o veículo? <a href="<?= BASE_URL ?>/veiculos/novo" style="color: var(--color-primary);">Cadastre um novo veículo aqui.</a></small>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="tecnico_id">Técnico Responsável *</label>
                <select name="tecnico_id" id="tecnico_id" class="form-control" required>
                    <option value="">Atribua a um técnico...</option>
                    <?php foreach ($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $_SESSION['user_id'] == $t['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nome_completo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="data_agendamento">Agendar para (Dia e Hora - Opcional)</label>
                <input type="datetime-local" name="data_agendamento" id="data_agendamento" class="form-control">
                <small style="display: block; margin-top: 4px; color: var(--color-mid);">Deixe em branco para iniciar imediatamente como "Em Andamento".</small>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" <?= empty($veiculos) ? 'disabled' : '' ?>><i class="fa-solid fa-play"></i> Iniciar / Agendar Serviço</button>
            <a href="<?= BASE_URL ?>/vistorias" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
