<!-- Painel Superior: Serviços Agendados e Calendário Mensal Interativo -->
<div class="panel" style="margin-bottom: 2rem; border-top: 4px solid var(--color-primary); box-shadow: var(--shadow-md);">
    <div class="dashboard-agenda-wrapper">
        
        <!-- Coluna 1: Quadro de Serviços Agendados -->
        <div class="agenda-column">
            <div class="agenda-header">
                <div>
                    <h3 style="margin: 0; color: var(--color-primary-dark); font-size: 1.15rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-calendar-check text-primary"></i>
                        <span>Serviços Agendados</span>
                    </h3>
                    <div id="agenda-subtitulo" style="font-size: 12px; color: var(--color-mid); margin-top: 4px; font-weight: 500;">
                        Carregando compromissos...
                    </div>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" id="btn-hoje-agenda" class="btn btn-secondary" onclick="irParaHoje()" style="font-size: 11px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px;" title="Retornar para hoje">
                        <i class="fa-solid fa-calendar-day"></i>
                        <span>Hoje</span>
                        <span id="badge-total-hoje" class="badge" style="background: var(--color-primary); color: #fff; font-size: 10px; padding: 2px 7px; border-radius: 12px; font-weight: 700;">
                            <?= $totalAgendadosHoje ?? 0 ?>
                        </span>
                    </button>
                    <?php if (!$isTecnico): ?>
                        <a href="<?= BASE_URL ?>/veiculos" class="btn btn-primary" style="font-size: 11px; padding: 6px 12px;">
                            <i class="fa-solid fa-plus"></i> Novo Agendamento
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Lista dinâmica de serviços agendados -->
            <div id="agenda-lista" style="max-height: 380px; overflow-y: auto; padding-right: 6px; margin-top: 14px;">
                <!-- Preenchido via JavaScript -->
            </div>
        </div>

        <!-- Coluna 2: Calendário Mensal Interativo -->
        <div class="calendar-column">
            <div class="calendar-nav">
                <div style="display: flex; gap: 4px;">
                    <button type="button" class="btn-cal-nav" onclick="mudarAno(-1)" title="Ano Anterior"><i class="fa-solid fa-angles-left"></i></button>
                    <button type="button" class="btn-cal-nav" onclick="mudarMes(-1)" title="Mês Anterior"><i class="fa-solid fa-chevron-left"></i></button>
                </div>
                <div id="calendar-month-year" style="font-weight: 700; color: var(--color-primary-dark); font-size: 14px; text-transform: capitalize;">
                    Carregando...
                </div>
                <div style="display: flex; gap: 4px;">
                    <button type="button" class="btn-cal-nav" onclick="mudarMes(1)" title="Próximo Mês"><i class="fa-solid fa-chevron-right"></i></button>
                    <button type="button" class="btn-cal-nav" onclick="mudarAno(1)" title="Próximo Ano"><i class="fa-solid fa-angles-right"></i></button>
                </div>
            </div>

            <div class="calendar-weekdays">
                <span>Dom</span><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span>
            </div>

            <div id="calendar-days-grid" class="calendar-grid">
                <!-- Dias inseridos via JS -->
            </div>

            <div class="calendar-legend">
                <div class="legend-item"><span class="dot-servico"></span> Com serviço</div>
                <div class="legend-item"><span class="dot-hoje"></span> Hoje</div>
                <div class="legend-item"><span class="dot-selecionado"></span> Selecionado</div>
            </div>
        </div>

    </div>
</div>

<!-- Grid de Indicadores Estatísticos -->
<div class="dashboard-grid">
    <?php if ($isTecnico): ?>
        <div class="stat-card" id="card-veiculos" onclick="showSection('concluidas', 'card-veiculos')" style="cursor: pointer;">
            <h3>Serviços Realizados</h3>
            <div class="value text-primary"><?= $servicosRealizadosCount ?></div>
            <i class="fa-solid fa-clipboard-check icon"></i>
        </div>
    <?php else: ?>
        <div class="stat-card" id="card-veiculos" onclick="showSection('veiculos', 'card-veiculos')" style="cursor: pointer;">
            <h3>Veículos Cadastrados</h3>
            <div class="value text-primary"><?= $veiculosCount ?></div>
            <i class="fa-solid fa-car icon"></i>
        </div>
    <?php endif; ?>
    <div class="stat-card" id="card-andamento" onclick="showSection('andamento', 'card-andamento')" style="cursor: pointer;">
        <h3>Serviços em Andamento</h3>
        <div class="value" style="color: var(--color-warning);"><?= $vistoriasAndamento ?></div>
        <i class="fa-solid fa-spinner icon" style="color: var(--color-warning);"></i>
    </div>
    <div class="stat-card" id="card-concluidas" onclick="showSection('concluidas', 'card-concluidas')" style="cursor: pointer;">
        <h3>Serviços Concluídos</h3>
        <div class="value" style="color: var(--color-success);"><?= $vistoriasConcluidas ?></div>
        <i class="fa-solid fa-check-circle icon" style="color: var(--color-success);"></i>
    </div>
    <div class="stat-card" id="card-canceladas" onclick="showSection('canceladas')" style="cursor: pointer;">
        <h3>Serviços Cancelados</h3>
        <div class="value" style="color: var(--color-danger);"><?= $vistoriasCanceladas ?></div>
        <i class="fa-solid fa-times-circle icon" style="color: var(--color-danger);"></i>
    </div>
</div>

<!-- Painel de Boas Vindas Padrão -->
<div class="panel" id="welcome-panel" style="margin-top: 1.5rem;">
    <h3 style="color: var(--color-primary-dark); margin-bottom: 0.75rem;">Bem-vindo ao Sistema de Serviços, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>!</h3>
    <p style="margin-bottom: 1rem; color: var(--color-mid);">Utilize o quadro superior para acompanhar os agendamentos por data no calendário interativo ou clique nos indicadores acima para detalhar o catálogo e serviços.</p>
    <div style="background: var(--color-surface); padding: 12px 16px; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary); font-size: 13px;">
        <i class="fa-solid fa-info-circle text-primary"></i> <strong>Produtividade:</strong> Clique sobre qualquer dia do calendário para ver instantaneamente a escala de trabalho, veículos e técnicos programados para aquela data.
    </div>
</div>

<!-- Container de Listas Detalhadas (Injetadas e chaveadas via JS) -->
<div class="panel" id="details-container" style="display: none; margin-top: 1.5rem;">
    
    <!-- Seção de Veículos Cadastrados -->
    <div id="section-veiculos" class="detail-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0; color: var(--color-primary-dark);">Catálogo de Veículos</h3>
            <?php if (in_array($_SESSION['user_profile'], ['Administrador', 'Gerente', 'Supervisor'])): ?>
                <a href="<?= BASE_URL ?>/veiculos/novo" class="btn btn-primary" style="padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Novo Veículo</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Fabricante / Modelo</th>
                        <th>Tipo de Serviço</th>
                        <th>Ano</th>
                        <th>Proprietário</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($veiculos)): ?>
                        <tr><td colspan="7" style="text-align: center;">Nenhum veículo cadastrado.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($veiculos as $v): ?>
                    <tr>
                        <td>
                            <strong>
                                <a href="<?= BASE_URL ?>/veiculos/visualizar/<?= $v['id'] ?>" style="color: var(--color-primary); text-decoration: none;">
                                    <i class="fa-solid fa-car-side"></i> <?= htmlspecialchars($v['placa']) ?>
                                </a>
                            </strong>
                        </td>
                        <td><?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo']) ?></td>
                        <td>
                            <?php if (!empty($v['tipo_reparo'])): ?>
                                <span class="badge" style="background: var(--color-primary-dark); font-size: 10px;"><?= htmlspecialchars($v['tipo_reparo']) ?></span>
                                <?php if (!empty($v['classificacao_vidro'])): ?>
                                    <small style="display: block; color: var(--color-mid); font-size: 11px;"><?= htmlspecialchars($v['classificacao_vidro']) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color: var(--color-mid); font-size: 11px;">Não especificado</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($v['ano_fabricacao'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($v['nome_proprietario'] ?? '-') ?></td>
                        <td>
                            <?php if (!empty($v['ativo'])): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/veiculos/visualizar/<?= $v['id'] ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px;"><i class="fa-solid fa-search"></i> Visualizar</a>
                            <?php if (in_array($_SESSION['user_profile'], ['Administrador', 'Gerente', 'Supervisor'])): ?>
                                <a href="<?= BASE_URL ?>/veiculos/editar/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px;"><i class="fa-solid fa-edit"></i> Editar</a>
                                <?php if (!empty($v['ativo'])): ?>
                                    <a href="<?= BASE_URL ?>/veiculos/desativar/<?= $v['id'] ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 11px;" onclick="return confirm('Deseja desativar este veículo?')"><i class="fa-solid fa-ban"></i> Desativar</a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/veiculos/ativar/<?= $v['id'] ?>" class="btn btn-success" style="padding: 6px 12px; font-size: 11px;" onclick="return confirm('Deseja reativar este veículo?')"><i class="fa-solid fa-check"></i> Reativar</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Seção de Serviços em Andamento -->
    <div id="section-andamento" class="detail-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0; color: var(--color-warning);">Serviços Em Andamento</h3>
            <?php if (!$isTecnico): ?>
                <a href="<?= BASE_URL ?>/vistorias/nova" class="btn btn-primary" style="padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Iniciar Serviço</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Técnico</th>
                        <th>Início do Serviço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vistoriasAndamentoList)): ?>
                        <tr><td colspan="6" style="text-align: center;">Nenhum serviço em andamento.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($vistoriasAndamentoList as $v): ?>
                    <tr>
                        <td><strong>#<?= str_pad($v['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                        <td>
                            <a href="<?= BASE_URL ?>/vistorias/executar/<?= $v['id'] ?>" style="color: var(--color-primary); text-decoration: none; font-weight: bold;">
                                <?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo'] . ' (' . $v['placa'] . ')') ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($v['nome_tecnico'] ?? '-') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['data_inicio'])) ?></td>
                        <td><span class="badge" style="background: var(--color-warning);">Em Andamento</span></td>
                        <td>
                            <a href="<?= BASE_URL ?>/vistorias/executar/<?= $v['id'] ?>" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px;"><i class="fa-solid fa-play"></i> Continuar Serviço</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Seção de Serviços Concluídos -->
    <div id="section-concluidas" class="detail-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; color: var(--color-success);">Serviços Concluídos</h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Técnico</th>
                        <th>Data Conclusão</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vistoriasConcluidasList)): ?>
                        <tr><td colspan="6" style="text-align: center;">Nenhum serviço concluído ainda.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($vistoriasConcluidasList as $v): ?>
                    <tr>
                        <td><strong>#<?= str_pad($v['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                        <td>
                            <a href="<?= BASE_URL ?>/vistorias/pdf/<?= $v['id'] ?>" style="color: var(--color-success); text-decoration: none; font-weight: bold;">
                                <?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo'] . ' (' . $v['placa'] . ')') ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($v['nome_tecnico'] ?? '-') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['data_fim'])) ?></td>
                        <td><span class="badge" style="background: var(--color-success);">Concluído</span></td>
                        <td>
                            <a href="<?= BASE_URL ?>/vistorias/pdf/<?= $v['id'] ?>" class="btn btn-success" style="padding: 6px 12px; font-size: 11px;"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Seção de Serviços Cancelados -->
    <div id="section-canceladas" class="detail-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; color: var(--color-danger);">Serviços Cancelados</h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Técnico</th>
                        <th>Data Registro</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vistoriasCanceladasList)): ?>
                        <tr><td colspan="5" style="text-align: center;">Nenhum serviço cancelado.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($vistoriasCanceladasList as $v): ?>
                    <tr>
                        <td><strong>#<?= str_pad($v['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                        <td><?= htmlspecialchars($v['fabricante'] . ' ' . $v['modelo'] . ' (' . $v['placa'] . ')') ?></td>
                        <td><?= htmlspecialchars($v['nome_tecnico'] ?? '-') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['data_inicio'])) ?></td>
                        <td>
                            <span class="badge" style="background: var(--color-danger);" title="<?= htmlspecialchars($v['motivo_cancelamento'] ?? '') ?>">Cancelado</span>
                            <?php if (!empty($v['motivo_cancelamento'])): ?>
                                <small style="display: block; color: var(--color-mid); font-style: italic; margin-top: 3px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($v['motivo_cancelamento']) ?>">
                                    Motivo: <?= htmlspecialchars($v['motivo_cancelamento']) ?>
                                </small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
/* Layout Responsivo do Painel Superior */
.dashboard-agenda-wrapper {
    display: grid;
    grid-template-columns: 1fr 370px;
    gap: 24px;
    align-items: start;
}

@media (max-width: 992px) {
    .dashboard-agenda-wrapper {
        grid-template-columns: 1fr;
    }
}

.agenda-column {
    min-height: 380px;
}

.agenda-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--color-border);
    padding-bottom: 12px;
}

.agenda-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: 12px 16px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}

.agenda-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
    border-color: var(--color-primary-light);
}

.agenda-card-time {
    font-size: 15px;
    font-weight: 700;
    color: var(--color-primary);
    display: flex;
    align-items: center;
    gap: 6px;
    min-width: 75px;
}

.agenda-card-body {
    flex: 1;
}

.agenda-card-body .vehicle-title {
    font-weight: 700;
    font-size: 13px;
    color: var(--color-dark);
}

.agenda-card-body .vehicle-info {
    font-size: 11px;
    color: var(--color-mid);
    margin-top: 2px;
}

.agenda-card-body .tech-info {
    font-size: 11px;
    color: var(--color-primary-dark);
    font-weight: 600;
    margin-top: 3px;
}

/* Coluna do Calendário */
.calendar-column {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: 16px;
}

.calendar-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}

.btn-cal-nav {
    background: #fff;
    border: 1px solid var(--color-border);
    color: var(--color-dark);
    border-radius: 4px;
    padding: 5px 9px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cal-nav:hover {
    background: var(--color-primary);
    color: #fff;
    border-color: var(--color-primary);
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-weight: 700;
    font-size: 11px;
    color: var(--color-mid);
    margin-bottom: 8px;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
    text-align: center;
}

.cal-day-cell {
    aspect-ratio: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    position: relative;
    user-select: none;
    transition: all 0.15s;
    background: #fff;
    border: 1px solid transparent;
}

.cal-day-cell:hover {
    border-color: var(--color-primary);
    background: rgba(7, 94, 84, 0.05);
}

.cal-day-other-month {
    color: #c0c0c0;
    background: transparent;
    cursor: default;
}

.cal-day-other-month:hover {
    border-color: transparent;
    background: transparent;
}

.cal-day-today {
    font-weight: 700;
    border-color: var(--color-primary) !important;
}

.cal-day-selected {
    background: var(--color-primary) !important;
    color: #fff !important;
    font-weight: 700;
}

.cal-day-has-events::after {
    content: '';
    position: absolute;
    bottom: 3px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--color-primary-light);
}

.cal-day-selected.cal-day-has-events::after {
    background: #fff;
}

.calendar-legend {
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px dashed var(--color-border);
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--color-mid);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

.dot-servico {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--color-primary-light);
}

.dot-hoje {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    border: 2px solid var(--color-primary);
    background: #fff;
}

.dot-selecionado {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 2px;
    background: var(--color-primary);
}

.active-card {
    border-top: 4px solid var(--color-primary-light) !important;
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg) !important;
    background: rgba(7, 94, 84, 0.03) !important;
}
</style>

<script>
// Dados recebidos do Backend
const todosServicos = <?= json_encode($todosServicos, JSON_UNESCAPED_UNICODE) ?> || [];
const isTecnico = <?= $isTecnico ? 'true' : 'false' ?>;
const baseUrl = '<?= BASE_URL ?>';
const hojeStr = '<?= $dataHoje ?>';

const meses = [
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];

// Helper para obter a data YYYY-MM-DD de um serviço
function getServiceDate(item) {
    if (item.data_agendamento && item.data_agendamento.length >= 10) {
        return item.data_agendamento.substring(0, 10);
    }
    if (item.data_inicio && item.data_inicio.length >= 10) {
        return item.data_inicio.substring(0, 10);
    }
    if (item.data_criacao && item.data_criacao.length >= 10) {
        return item.data_criacao.substring(0, 10);
    }
    return null;
}

// Helper para obter o horário HH:mm de um serviço
function getServiceTime(item) {
    const dt = item.data_agendamento || item.data_inicio || item.data_criacao;
    if (dt && dt.length >= 16) {
        return dt.substring(11, 16);
    }
    return '--:--';
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Mapeia serviços agrupados por data
const eventsByDate = {};
todosServicos.forEach(item => {
    const d = getServiceDate(item);
    if (d) {
        if (!eventsByDate[d]) eventsByDate[d] = [];
        eventsByDate[d].push(item);
    }
});

// Estado atual de navegação do calendário
const [hAno, hMes, hDia] = hojeStr.split('-').map(Number);
let curYear = hAno;
let curMonth = hMes - 1; // 0-indexed
let selectedDate = hojeStr;

// Renderiza a lista de serviços agendados para a data selecionada
function renderScheduledList(dateStr) {
    const container = document.getElementById('agenda-lista');
    const subtitulo = document.getElementById('agenda-subtitulo');
    
    const parts = dateStr.split('-');
    const formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
    const isSelectedToday = (dateStr === hojeStr);

    subtitulo.innerHTML = isSelectedToday 
        ? `Exibindo compromissos para <strong>Hoje (${formattedDate})</strong>`
        : `Exibindo compromissos para <strong>${formattedDate}</strong>`;

    const items = eventsByDate[dateStr] ? [...eventsByDate[dateStr]] : [];

    // Ordena por horário crescente
    items.sort((a, b) => getServiceTime(a).localeCompare(getServiceTime(b)));

    if (items.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px 20px; background: var(--color-surface); border-radius: var(--radius-md); border: 1px dashed var(--color-border); margin-top: 10px;">
                <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: var(--color-mid); margin-bottom: 10px; display: block;"></i>
                <p style="margin: 0; font-weight: 600; color: var(--color-dark); font-size: 13px;">Nenhum serviço agendado para ${formattedDate}.</p>
                <p style="margin: 4px 0 0 0; font-size: 11px; color: var(--color-mid);">Clique em uma data com ponto indicador no calendário para visualizar os agendamentos.</p>
            </div>
        `;
        return;
    }

    let html = '';
    items.forEach(item => {
        const time = getServiceTime(item);
        let statusBadge = '';
        let actionBtn = '';

        const status = item.status || 'Agendado';
        if (status === 'Agendado') {
            statusBadge = `<span class="badge" style="background: var(--color-primary);">Agendado</span>`;
            actionBtn = `<a href="${baseUrl}/vistorias/iniciar/${item.id}" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px; white-space: nowrap;"><i class="fa-solid fa-play"></i> Iniciar</a>`;
        } else if (status === 'Em Andamento') {
            statusBadge = `<span class="badge" style="background: var(--color-warning);">Em Andamento</span>`;
            actionBtn = `<a href="${baseUrl}/vistorias/executar/${item.id}" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px; background: var(--color-warning); border-color: var(--color-warning); white-space: nowrap;"><i class="fa-solid fa-wrench"></i> Continuar</a>`;
        } else if (status === 'Concluído') {
            statusBadge = `<span class="badge" style="background: var(--color-success);">Concluído</span>`;
            actionBtn = `<a href="${baseUrl}/vistorias/pdf/${item.id}" class="btn btn-success" style="padding: 6px 12px; font-size: 11px; white-space: nowrap;"><i class="fa-solid fa-file-pdf"></i> Laudo PDF</a>`;
        } else if (status === 'Cancelado') {
            statusBadge = `<span class="badge" style="background: var(--color-danger);">Cancelado</span>`;
            actionBtn = `<span style="font-size: 11px; color: var(--color-danger); font-weight: 600;"><i class="fa-solid fa-ban"></i> Cancelado</span>`;
        }

        const motivoTag = item.motivo_servico 
            ? `<span class="badge" style="background: var(--color-secondary); font-size: 9px; margin-left: 4px;">${escapeHtml(item.motivo_servico)}</span>` 
            : '';

        const servicoInfo = (item.tipo_reparo || item.classificacao_vidro)
            ? `${item.tipo_reparo || ''} ${item.classificacao_vidro ? '• ' + item.classificacao_vidro : ''}`
            : 'Vistoria e Reparo Veicular';

        html += `
            <div class="agenda-card">
                <div class="agenda-card-time">
                    <i class="fa-regular fa-clock"></i>
                    <span>${time}</span>
                </div>
                <div class="agenda-card-body">
                    <div class="vehicle-title">
                        <span class="badge" style="background: var(--color-primary-dark); font-size: 10px; margin-right: 4px;">${escapeHtml(item.placa)}</span>
                        ${escapeHtml(item.fabricante || '')} ${escapeHtml(item.modelo || '')}
                        ${motivoTag}
                    </div>
                    <div class="vehicle-info">
                        <i class="fa-solid fa-wrench" style="font-size: 10px;"></i> ${escapeHtml(servicoInfo)}
                        ${item.nome_proprietario ? ' • Cliente: ' + escapeHtml(item.nome_proprietario) : ''}
                    </div>
                    <div class="tech-info">
                        <i class="fa-solid fa-user-gear"></i> Técnico: ${escapeHtml(item.nome_tecnico || 'Não atribuído')}
                        <span style="margin-left: 8px;">${statusBadge}</span>
                    </div>
                </div>
                <div style="text-align: right;">
                    ${actionBtn}
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// Renderiza a grade de dias do calendário para curMonth e curYear
function renderCalendar() {
    const monthYearTitle = document.getElementById('calendar-month-year');
    monthYearTitle.textContent = `${meses[curMonth]} ${curYear}`;

    const grid = document.getElementById('calendar-days-grid');
    grid.innerHTML = '';

    const firstDayWeek = new Date(curYear, curMonth, 1).getDay(); // 0 = Dom
    const totalDays = new Date(curYear, curMonth + 1, 0).getDate();
    const prevMonthTotalDays = new Date(curYear, curMonth, 0).getDate();

    // Dias do mês anterior para completar primeira semana
    for (let i = firstDayWeek - 1; i >= 0; i--) {
        const dayNum = prevMonthTotalDays - i;
        const cell = document.createElement('div');
        cell.className = 'cal-day-cell cal-day-other-month';
        cell.textContent = dayNum;
        grid.appendChild(cell);
    }

    // Dias do mês atual
    for (let day = 1; day <= totalDays; day++) {
        const dateStr = `${curYear}-${String(curMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const cell = document.createElement('div');
        cell.className = 'cal-day-cell';
        cell.textContent = day;

        if (dateStr === hojeStr) {
            cell.classList.add('cal-day-today');
            cell.setAttribute('title', 'Hoje');
        }

        if (dateStr === selectedDate) {
            cell.classList.add('cal-day-selected');
        }

        const count = eventsByDate[dateStr] ? eventsByDate[dateStr].length : 0;
        if (count > 0) {
            cell.classList.add('cal-day-has-events');
            cell.setAttribute('title', `${count} serviço(s) agendado(s)`);
        }

        cell.addEventListener('click', function () {
            selectedDate = dateStr;
            renderCalendar();
            renderScheduledList(dateStr);
        });

        grid.appendChild(cell);
    }

    // Preenchimento de dias posteriores para fechar semanas completas
    const totalRendered = firstDayWeek + totalDays;
    const nextMonthPadding = (7 - (totalRendered % 7)) % 7;
    for (let day = 1; day <= nextMonthPadding; day++) {
        const cell = document.createElement('div');
        cell.className = 'cal-day-cell cal-day-other-month';
        cell.textContent = day;
        grid.appendChild(cell);
    }
}

function mudarMes(delta) {
    curMonth += delta;
    if (curMonth < 0) {
        curMonth = 11;
        curYear--;
    } else if (curMonth > 11) {
        curMonth = 0;
        curYear++;
    }
    renderCalendar();
}

function mudarAno(delta) {
    curYear += delta;
    renderCalendar();
}

function irParaHoje() {
    curYear = hAno;
    curMonth = hMes - 1;
    selectedDate = hojeStr;
    renderCalendar();
    renderScheduledList(selectedDate);
}

// Chaveamento de seções dos indicadores
function showSection(sectionId, customCardKey = null) {
    const welcomePanel = document.getElementById('welcome-panel');
    if (welcomePanel) {
        welcomePanel.style.display = 'none';
    }

    const detailsContainer = document.getElementById('details-container');
    detailsContainer.style.display = 'block';

    document.querySelectorAll('.detail-section').forEach(el => {
        el.style.display = 'none';
    });

    const targetSection = document.getElementById('section-' + sectionId);
    if (targetSection) {
        targetSection.style.display = 'block';
    }

    document.querySelectorAll('.stat-card').forEach(el => {
        el.classList.remove('active-card');
    });

    let cardKey = customCardKey;
    if (!cardKey) {
        if (sectionId === 'veiculos') cardKey = 'card-veiculos';
        else if (sectionId === 'andamento') cardKey = 'card-andamento';
        else if (sectionId === 'concluidas') cardKey = 'card-concluidas';
        else if (sectionId === 'canceladas') cardKey = 'card-canceladas';
    }

    const selectedCard = document.getElementById(cardKey);
    if (selectedCard) {
        selectedCard.classList.add('active-card');
    }

    detailsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Inicializa na carga da página
document.addEventListener('DOMContentLoaded', function () {
    renderCalendar();
    renderScheduledList(selectedDate);

    // Sincroniza badge de total no botão Hoje
    const totalHoje = eventsByDate[hojeStr] ? eventsByDate[hojeStr].length : 0;
    const badgeHoje = document.getElementById('badge-total-hoje');
    if (badgeHoje) {
        badgeHoje.textContent = totalHoje;
    }
});
</script>
