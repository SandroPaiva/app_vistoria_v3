<div class="panel">
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Iniciar Nova Vistoria</h3>
        <p style="color: var(--color-mid); font-size: 13px;">Selecione o veículo e o técnico responsável para iniciar o processo de reparo.</p>
    </div>

    <form action="<?= BASE_URL ?>/vistorias/store" method="POST">
        <div class="form-group">
            <label class="form-label" for="veiculo_id">Veículo Alvo *</label>
            <select name="veiculo_id" id="veiculo_id" class="form-control" required>
                <option value="">Selecione o veículo pela placa ou modelo...</option>
                <?php foreach ($veiculos as $v): ?>
                    <option value="<?= $v['id'] ?>">
                        <?= htmlspecialchars($v['placa'] . ' - ' . $v['fabricante'] . ' ' . $v['modelo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small style="display: block; margin-top: 5px; color: var(--color-mid);">Não encontrou o veículo? <a href="<?= BASE_URL ?>/veiculos/novo" style="color: var(--color-primary);">Cadastre-o primeiro.</a></small>
        </div>

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

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-play"></i> Iniciar Vistoria</button>
            <a href="<?= BASE_URL ?>/vistorias" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>
