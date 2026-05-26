<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-dark); margin: 0;">Catálogo de Itens de Reparo</h3>
        <a href="<?= BASE_URL ?>/itens/novo" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo Item</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Reparo</th>
                    <th>Classificação do Vidro</th>
                    <th>Especificação (Outros)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($itens)): ?>
                    <tr><td colspan="5" style="text-align: center;">Nenhum item cadastrado.</td></tr>
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
                        <button class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
