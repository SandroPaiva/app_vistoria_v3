<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="color: var(--color-dark); margin: 0;">Veículos Cadastrados</h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">Gestão da frota, agendamentos e histórico de atendimentos veiculares.</p>
        </div>
        <a href="<?= BASE_URL ?>/veiculos/novo" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo Veículo</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Fabricante/Modelo</th>
                    <th>Tipo de Serviço</th>
                    <th>Proprietário / Telefone</th>
                    <th>Agendamento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($veiculos)): ?>
                    <tr><td colspan="7" style="text-align: center;">Nenhum veículo encontrado.</td></tr>
                <?php endif; ?>
                <?php foreach ($veiculos as $v): ?>
                <tr>
                    <td>
                        <strong style="font-size: 14px;"><?= htmlspecialchars($v['placa']) ?></strong>
                        <small style="display: block; color: var(--color-mid);"><?= htmlspecialchars($v['tipo_veiculo'] ?? 'Carro') ?></small>
                    </td>
                    <td>
                        <?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo']) ?>
                        <?php if (!empty($v['ano_fabricacao'])): ?>
                            <small style="color: var(--color-mid);">(<?= $v['ano_fabricacao'] ?>)</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($v['tipo_reparo'])): ?>
                            <span class="badge" style="background: var(--color-dark-mid); font-size: 11px;">
                                <?= htmlspecialchars($v['tipo_reparo'] . ' - ' . $v['classificacao_vidro']) ?>
                            </span>
                        <?php else: ?>
                            <span style="color: var(--color-mid); font-style: italic;">Não especificado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($v['nome_proprietario'] ?? 'Não informado') ?>
                        <?php if (!empty($v['telefone_proprietario'])): ?>
                            <small style="display: block; color: var(--color-mid);"><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($v['telefone_proprietario']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($v['data_agendamento'])): ?>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 12px;">
                                <i class="fa-regular fa-calendar-check"></i> <?= date('d/m/Y H:i', strtotime($v['data_agendamento'])) ?>
                            </span>
                            <?php if (!empty($v['nome_tecnico_agendado'])): ?>
                                <small style="display: block; color: var(--color-mid);">Téc: <?= htmlspecialchars($v['nome_tecnico_agendado']) ?></small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color: var(--color-mid); font-size: 12px;">Sem agendamento</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($v['ativo'] == 1): ?>
                            <span class="badge" style="background: var(--color-success);"><i class="fa-solid fa-check"></i> Ativo</span>
                        <?php else: ?>
                            <span class="badge" style="background: var(--color-mid);"><i class="fa-solid fa-xmark"></i> Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            <!-- Botão de Visualização / Histórico -->
                            <a href="<?= BASE_URL ?>/veiculos/visualizar/<?= $v['id'] ?>" class="btn btn-secondary" style="padding: 4px 8px; font-size: 11px;" title="Ver Detalhes e Histórico de Atendimentos">
                                <i class="fa-solid fa-eye"></i> Histórico
                            </a>

                            <!-- Botão Novo Serviço / Refazer para veículos que já tiveram serviços -->
                            <?php if (!empty($v['total_servicos']) && $v['total_servicos'] > 0): ?>
                                <a href="<?= BASE_URL ?>/veiculos/novo-servico/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px; background: var(--color-primary-light);" title="Novo Serviço / Refazer (Gera Histórico)">
                                    <i class="fa-solid fa-plus-circle"></i> Novo Serviço
                                </a>
                            <?php endif; ?>

                            <a href="<?= BASE_URL ?>/veiculos/editar/<?= $v['id'] ?>" class="btn btn-secondary" style="padding: 4px 8px; font-size: 11px;" title="Editar"><i class="fa-solid fa-edit"></i></a>

                            <?php if ($v['ativo'] == 1): ?>
                                <a href="<?= BASE_URL ?>/veiculos/desativar/<?= $v['id'] ?>" class="btn btn-danger" style="padding: 4px 8px; font-size: 11px;" onclick="return confirm('Deseja realmente desativar este veículo?')" title="Desativar"><i class="fa-solid fa-trash"></i></a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/veiculos/ativar/<?= $v['id'] ?>" class="btn btn-success" style="padding: 4px 8px; font-size: 11px;" onclick="return confirm('Deseja reativar este veículo?')" title="Reativar"><i class="fa-solid fa-check"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
