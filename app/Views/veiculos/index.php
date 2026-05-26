<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Veículos Cadastrados</h3>
        <a href="<?= BASE_URL ?>/veiculos/novo" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo Veículo</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Fabricante/Modelo</th>
                    <th>Ano</th>
                    <th>Proprietário</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($veiculos)): ?>
                    <tr><td colspan="6" style="text-align: center;">Nenhum veículo encontrado.</td></tr>
                <?php endif; ?>
                <?php foreach ($veiculos as $v): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($v['placa']) ?></strong></td>
                    <td><?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo']) ?></td>
                    <td><?= htmlspecialchars($v['ano_fabricacao']) ?></td>
                    <td><?= htmlspecialchars($v['nome_proprietario']) ?></td>
                    <td><?= htmlspecialchars($v['telefone_proprietario']) ?></td>
                    <td>
                        <button class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
