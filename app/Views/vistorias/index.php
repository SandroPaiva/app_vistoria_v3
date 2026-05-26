<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Vistorias Registradas</h3>
        <a href="<?= BASE_URL ?>/vistorias/nova" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Iniciar Nova Vistoria</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Veículo</th>
                    <th>Início</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vistorias)): ?>
                    <tr><td colspan="5" style="text-align: center;">Nenhuma vistoria encontrada.</td></tr>
                <?php endif; ?>
                <?php foreach ($vistorias as $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo'] . ' (' . $v['placa'] . ')') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($v['data_inicio'])) ?></td>
                    <td>
                        <?php 
                            $statusColor = $v['status'] === 'Concluído' ? 'var(--color-success)' : 
                                          ($v['status'] === 'Em Andamento' ? 'var(--color-warning)' : 'var(--color-danger)');
                        ?>
                        <span class="badge" style="background: <?= $statusColor ?>;">
                            <?= $v['status'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($v['status'] === 'Em Andamento'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/executar/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-play"></i> Continuar Reparo</a>
                        <?php endif; ?>
                        <?php if ($v['status'] === 'Concluído'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/pdf/<?= $v['id'] ?>" class="btn btn-success" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
