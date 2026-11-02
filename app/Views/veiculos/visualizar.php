<div class="panel">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-car"></i> Veículo: <?= htmlspecialchars($veiculo['placa']) ?>
            </h3>
            <p style="color: var(--color-mid); font-size: 13px; margin: 4px 0 0 0;">
                <?= htmlspecialchars($veiculo['fabricante'] . ' ' . $veiculo['modelo']) ?> | Proprietário: <strong><?= htmlspecialchars($veiculo['nome_proprietario'] ?? 'Não informado') ?></strong>
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <?php if (isset($_SESSION['user_profile']) && in_array($_SESSION['user_profile'], ['Administrador', 'Gerente', 'Supervisor'])): ?>
                <a href="<?= BASE_URL ?>/veiculos/novo-servico/<?= $veiculo['id'] ?>" class="btn btn-primary" style="padding: 8px 16px; font-size: 12px;" title="Novo Serviço">
                    <i class="fa-solid fa-plus"></i> Novo
                </a>
                <a href="<?= BASE_URL ?>/veiculos/editar/<?= $veiculo['id'] ?>" class="btn btn-secondary" style="padding: 8px 16px; font-size: 12px;">
                    <i class="fa-solid fa-edit"></i> Editar
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/veiculos" class="btn btn-secondary" style="padding: 8px 16px; font-size: 12px;">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Cards de Dados Cadastrais -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 2rem;">
        <div style="background: var(--color-surface); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
            <h4 style="margin: 0 0 12px 0; color: var(--color-primary-dark); font-size: 14px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
                <i class="fa-solid fa-id-card"></i> Identificação do Automóvel
            </h4>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Fabricante/Marca:</strong> <?= htmlspecialchars($veiculo['fabricante'] ?? 'Não informado') ?></p>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Modelo:</strong> <?= htmlspecialchars($veiculo['modelo'] ?? 'Não informado') ?></p>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Ano de Fabricação:</strong> <?= htmlspecialchars($veiculo['ano_fabricacao'] ?? 'Não informado') ?></p>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Tipo de Veículo:</strong> <?= htmlspecialchars($veiculo['tipo_veiculo']) ?></p>
            <p style="margin-bottom: 0; font-size: 13px;"><strong>Chassi:</strong> <?= htmlspecialchars($veiculo['chassi'] ?? 'Não informado') ?></p>
        </div>

        <div style="background: var(--color-surface); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
            <h4 style="margin: 0 0 12px 0; color: var(--color-primary-dark); font-size: 14px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
                <i class="fa-solid fa-user-tag"></i> Contato e Serviço Base
            </h4>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Nome do Proprietário:</strong> <?= htmlspecialchars($veiculo['nome_proprietario'] ?? 'Não informado') ?></p>
            <p style="margin-bottom: 8px; font-size: 13px;"><strong>Telefone do Proprietário:</strong> <?= htmlspecialchars($veiculo['telefone_proprietario'] ?? 'Não informado') ?></p>
            <p style="margin-bottom: 8px; font-size: 13px;">
                <strong>Item de Serviço Associado:</strong> 
                <?= $veiculo['item_reparo_id'] ? htmlspecialchars($veiculo['tipo_reparo'] . ' - ' . $veiculo['classificacao_vidro']) : 'Nenhum' ?>
            </p>
            <p style="margin-bottom: 0; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                <strong>Status do Cadastro:</strong>
                <span class="status-circle <?= $veiculo['ativo'] == 1 ? 'status-active' : 'status-inactive' ?>" title="<?= $veiculo['ativo'] == 1 ? 'Ativo' : 'Inativo' ?>" data-status="<?= $veiculo['ativo'] == 1 ? 'ativo' : 'inativo' ?>">
                    <i class="fa-solid <?= $veiculo['ativo'] == 1 ? 'fa-check' : 'fa-xmark' ?>"></i>
                </span>
            </p>
        </div>
    </div>

    <!-- Destaque: Próximo Atendimento Agendado -->
    <div style="background: #ffffff; border: 2px solid var(--color-primary); border-radius: var(--radius-md); padding: 20px; margin-bottom: 2rem; box-shadow: var(--shadow-sm);">
        <h4 style="margin: 0 0 10px 0; color: var(--color-primary); display: flex; align-items: center; gap: 8px; font-size: 15px;">
            <i class="fa-solid fa-calendar-star"></i> Próximo Atendimento Agendado
        </h4>
        <?php if (!empty($proximoAgendado)): ?>
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <p style="margin: 0 0 6px 0; font-size: 15px;">
                        Data e Horário: <strong style="color: var(--color-primary);"><?= date('d/m/Y \à\s H:i', strtotime($proximoAgendado['data_agendamento'])) ?></strong>
                    </p>
                    <p style="margin: 0 0 4px 0; font-size: 13px; color: var(--color-dark-mid);">
                        Técnico Responsável: <strong><?= htmlspecialchars($proximoAgendado['nome_tecnico']) ?></strong> | 
                        Item: <strong><?= htmlspecialchars($proximoAgendado['tipo_reparo'] . ' - ' . $proximoAgendado['classificacao_vidro']) ?></strong>
                    </p>
                    <?php if (!empty($proximoAgendado['observacao_motivo'])): ?>
                        <small style="color: var(--color-mid); font-style: italic;">Observação: <?= htmlspecialchars($proximoAgendado['observacao_motivo']) ?></small>
                    <?php endif; ?>
                </div>
                <a href="<?= BASE_URL ?>/vistorias/iniciar/<?= $proximoAgendado['id'] ?>" class="btn btn-primary" style="padding: 8px 18px; font-size: 12px;">
                    <i class="fa-solid fa-play"></i> Iniciar Atendimento Agora
                </a>
            </div>
        <?php else: ?>
            <p style="color: var(--color-mid); margin: 0; font-size: 13px;">
                <i class="fa-regular fa-calendar-check" style="margin-right: 6px;"></i> Não há atendimentos futuros agendados para este veículo no momento.
            </p>
        <?php endif; ?>
    </div>

    <!-- Tabela: Histórico Completo de Atendimentos -->
    <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-bottom: 15px; color: var(--color-dark);">
        <i class="fa-solid fa-clock-rotate-left"></i> Histórico Completo de Atendimentos (<?= count($historicoServicos) ?>)
    </h4>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>OS / ID</th>
                    <th>Data Realização</th>
                    <th>Técnico</th>
                    <th>Item de Serviço</th>
                    <th>Motivo</th>
                    <th>Observação Complementar</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($historicoServicos)): ?>
                    <tr><td colspan="8" style="text-align: center; color: var(--color-mid);">Nenhum atendimento realizado para este veículo até o momento.</td></tr>
                <?php endif; ?>
                <?php foreach ($historicoServicos as $h): ?>
                <tr>
                    <td><strong>#<?= $h['id'] ?></strong></td>
                    <td>
                        <?= !empty($h['data_agendamento']) ? date('d/m/Y H:i', strtotime($h['data_agendamento'])) : date('d/m/Y H:i', strtotime($h['data_inicio'])) ?>
                    </td>
                    <td><?= htmlspecialchars($h['nome_tecnico'] ?? '-') ?></td>
                    <td>
                        <?= !empty($h['tipo_reparo']) ? htmlspecialchars($h['tipo_reparo'] . ' - ' . $h['classificacao_vidro']) : 'Não especificado' ?>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--color-dark-mid); font-size: 10px;">
                            <?= htmlspecialchars($h['motivo_servico'] ?? 'Primeiro Serviço') ?>
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 12px; color: var(--color-mid);" title="<?= htmlspecialchars($h['observacao_motivo'] ?? '') ?>">
                            <?= !empty($h['observacao_motivo']) ? htmlspecialchars($h['observacao_motivo']) : '-' ?>
                        </span>
                    </td>
                    <td>
                        <?php 
                            $statusColor = 'var(--color-primary)';
                            if ($h['status'] === 'Concluído') $statusColor = 'var(--color-success)';
                            elseif ($h['status'] === 'Em Andamento') $statusColor = 'var(--color-warning)';
                            elseif ($h['status'] === 'Cancelado') $statusColor = 'var(--color-danger)';
                        ?>
                        <span class="badge" style="background: <?= $statusColor ?>;">
                            <?= $h['status'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($h['status'] === 'Concluído'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/pdf/<?= $h['id'] ?>" class="btn btn-success" style="padding: 4px 8px; font-size: 11px;" title="Visualizar Laudo A4 PDF">
                                <i class="fa-solid fa-file-pdf"></i> PDF
                            </a>
                        <?php elseif ($h['status'] === 'Agendado'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/iniciar/<?= $h['id'] ?>" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px;">
                                <i class="fa-solid fa-play"></i> Iniciar
                            </a>
                        <?php elseif ($h['status'] === 'Em Andamento'): ?>
                            <a href="<?= BASE_URL ?>/vistorias/executar/<?= $h['id'] ?>" class="btn btn-warning" style="padding: 4px 8px; font-size: 11px; background: var(--color-warning); color: #fff;">
                                <i class="fa-solid fa-play"></i> Continuar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
