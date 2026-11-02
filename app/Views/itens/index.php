<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0;">Catálogo de Itens de Serviço</h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">Catálogo oficial de vidros e tipos de reparo oferecidos pela Pilkington.</p>
        </div>
        <a href="<?= BASE_URL ?>/itens/novo" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo Item</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Serviço</th>
                    <th>Classificação do Vidro</th>
                    <th>Especificação (Outros)</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($itens)): ?>
                    <tr><td colspan="6" style="text-align: center;">Nenhum item cadastrado.</td></tr>
                <?php endif; ?>
                <?php foreach ($itens as $i): ?>
                <tr>
                    <td><?= $i['id'] ?></td>
                    <td>
                        <span class="badge" style="background: <?= $i['tipo_reparo'] === 'Troca completa' ? 'var(--color-primary)' : 'var(--color-mid)' ?>;">
                            <?= htmlspecialchars($i['tipo_reparo']) ?>
                        </span>
                    </td>
                    <td><strong><?= htmlspecialchars($i['classificacao_vidro']) ?></strong></td>
                    <td><?= htmlspecialchars($i['especificacao_outros'] ?? '-') ?></td>
                    <td>
                        <?php if ($i['ativo'] == 1): ?>
                            <span class="status-circle status-active" title="Ativo" data-status="ativo"><i class="fa-solid fa-check"></i></span>
                        <?php else: ?>
                            <span class="status-circle status-inactive" title="Inativo" data-status="inativo"><i class="fa-solid fa-xmark"></i></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/itens/editar/<?= $i['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;" title="Editar"><i class="fa-solid fa-edit"></i></a>
                        <?php if ($i['ativo'] == 1): ?>
                            <a href="<?= BASE_URL ?>/itens/desativar/<?= $i['id'] ?>" class="btn btn-danger" style="padding: 4px 10px; font-size: 11px;" onclick="return confirm('Deseja realmente desativar este item de serviço?')" title="Desativar"><i class="fa-solid fa-trash"></i></a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/itens/ativar/<?= $i['id'] ?>" class="btn btn-reativar" style="padding: 4px 10px; font-size: 11px;" onclick="return confirm('Deseja reativar este item?')" title="Reativar"><i class="fa-solid fa-check"></i> Reativar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
