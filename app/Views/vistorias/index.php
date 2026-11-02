<!-- Quadro de Serviços Agendados para o Dia -->
<div class="panel" style="margin-bottom: 1.5rem; border-left: 5px solid var(--color-primary); background: #ffffff;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-calendar-check" style="color: var(--color-primary);"></i> Serviços Agendados para Hoje (<?= date('d/m/Y') ?>)
            </h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">
                <?= $isTecnico ? 'Seus atendimentos programados para a jornada de hoje.' : 'Atendimentos programados de toda a equipe para o dia de hoje.' ?>
            </p>
        </div>
        <span class="badge" style="background: var(--color-primary); font-size: 13px; padding: 6px 14px;">
            <?= count($agendadosHoje) ?> agendado(s)
        </span>
    </div>

    <?php if (empty($agendadosHoje)): ?>
        <div style="background: var(--color-surface); padding: 25px; border-radius: var(--radius-md); text-align: center; color: var(--color-mid); border: 1px dashed var(--color-border);">
            <i class="fa-regular fa-calendar-xmark" style="font-size: 26px; margin-bottom: 8px; display: block; color: var(--color-mid);"></i>
            Nenhum serviço agendado para o dia de hoje.
        </div>
    <?php else: ?>
        <div class="table-responsive" style="margin-top: 10px;">
            <table class="table" style="margin: 0; background: var(--color-surface); border-radius: var(--radius-md);" data-no-tools="true">
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Veículo</th>
                        <th>Cliente</th>
                        <th>Item de Serviço</th>
                        <?php if (!$isTecnico): ?>
                            <th>Técnico</th>
                        <?php endif; ?>
                        <th>Motivo</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendadosHoje as $ag): ?>
                    <tr>
                        <td>
                            <strong style="color: var(--color-primary); font-size: 14px;">
                                <i class="fa-regular fa-clock"></i> 
                                <?= !empty($ag['data_agendamento']) ? date('H:i', strtotime($ag['data_agendamento'])) : date('H:i', strtotime($ag['data_inicio'])) ?>
                            </strong>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($ag['placa']) ?></strong>
                            <small style="display: block; color: var(--color-mid);"><?= htmlspecialchars($ag['fabricante'] . ' ' . $ag['modelo']) ?></small>
                        </td>
                        <td>
                            <?= htmlspecialchars($ag['nome_proprietario'] ?? 'Não informado') ?>
                            <?php if (!empty($ag['telefone_proprietario'])): ?>
                                <small style="display: block; color: var(--color-mid);"><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($ag['telefone_proprietario']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= !empty($ag['tipo_reparo']) ? htmlspecialchars($ag['tipo_reparo'] . ' - ' . $ag['classificacao_vidro']) : 'Não especificado' ?>
                        </td>
                        <?php if (!$isTecnico): ?>
                            <td><?= htmlspecialchars($ag['nome_tecnico'] ?? '-') ?></td>
                        <?php endif; ?>
                        <td>
                            <span class="badge" style="background: var(--color-dark-mid); font-size: 10px;">
                                <?= htmlspecialchars($ag['motivo_servico'] ?? 'Primeiro Serviço') ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge" style="background: <?= $ag['status'] === 'Em Andamento' ? 'var(--color-warning)' : 'var(--color-primary)' ?>;">
                                <?= $ag['status'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($ag['status'] === 'Agendado'): ?>
                                <a href="<?= BASE_URL ?>/vistorias/iniciar/<?= $ag['id'] ?>" class="btn btn-primary" style="padding: 6px 14px; font-size: 11px;">
                                    <i class="fa-solid fa-play"></i> Iniciar Serviço
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/vistorias/executar/<?= $ag['id'] ?>" class="btn btn-warning" style="padding: 6px 14px; font-size: 11px; background: var(--color-warning); color: #fff;">
                                    <i class="fa-solid fa-spinner"></i> Continuar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Painel Principal de Serviços Registrados -->
<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0;">Histórico Geral de Serviços</h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">Acompanhe o andamento de todos os atendimentos e laudos técnicos gerados.</p>
        </div>
        <?php if (!$isTecnico): ?>
            <a href="<?= BASE_URL ?>/vistorias/nova" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Iniciar Novo Serviço</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Veículo</th>
                    <th>Técnico</th>
                    <th>Agendado / Início</th>
                    <th>Motivo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vistorias)): ?>
                    <tr><td colspan="7" style="text-align: center;">Nenhum serviço encontrado.</td></tr>
                <?php endif; ?>
                <?php foreach ($vistorias as $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($v['placa']) ?></strong>
                        <small style="display: block; color: var(--color-mid);"><?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($v['nome_tecnico'] ?? '-') ?></td>
                    <td>
                        <?php if (!empty($v['data_agendamento'])): ?>
                            <span title="Data de Agendamento"><i class="fa-regular fa-calendar" style="color: var(--color-primary);"></i> <?= date('d/m/Y H:i', strtotime($v['data_agendamento'])) ?></span>
                        <?php else: ?>
                            <span title="Data de Início"><i class="fa-regular fa-clock" style="color: var(--color-mid);"></i> <?= date('d/m/Y H:i', strtotime($v['data_inicio'])) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--color-dark-mid); font-size: 10px;">
                            <?= htmlspecialchars($v['motivo_servico'] ?? 'Primeiro Serviço') ?>
                        </span>
                        <?php if (!empty($v['observacao_motivo'])): ?>
                            <small style="display: block; color: var(--color-mid); font-style: italic; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($v['observacao_motivo']) ?>">
                                <?= htmlspecialchars($v['observacao_motivo']) ?>
                            </small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php 
                            $statusColor = 'var(--color-primary)';
                            if ($v['status'] === 'Concluído') $statusColor = 'var(--color-success)';
                            elseif ($v['status'] === 'Em Andamento') $statusColor = 'var(--color-warning)';
                            elseif ($v['status'] === 'Cancelado') $statusColor = 'var(--color-danger)';
                        ?>
                        <span class="badge" style="background: <?= $statusColor ?>;" title="<?= htmlspecialchars($v['motivo_cancelamento'] ?? '') ?>">
                            <?= $v['status'] ?>
                        </span>
                        <?php if ($v['status'] === 'Cancelado' && !empty($v['motivo_cancelamento'])): ?>
                            <small style="display: block; color: var(--color-mid); font-style: italic; margin-top: 3px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($v['motivo_cancelamento']) ?>">
                                Motivo: <?= htmlspecialchars($v['motivo_cancelamento']) ?>
                            </small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($v['status'] === 'Agendado'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/iniciar/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-play"></i> Iniciar</a>
                        <?php elseif ($v['status'] === 'Em Andamento'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/executar/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-play"></i> Continuar</a>
                        <?php endif; ?>
                        <?php if ($v['status'] === 'Concluído'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/pdf/<?= $v['id'] ?>" class="btn btn-success" style="padding: 4px 10px; font-size: 11px;"><i class="fa-solid fa-file-pdf"></i> Laudo PDF</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
