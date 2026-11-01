<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Veiculo;
use app\Models\Vistoria;

class DashboardController extends Controller {
    public function index() {
        $this->requireLogin();

        // Veículos com informações do item de reparo e histórico
        $veiculos = Veiculo::allWithItem();

        $isTecnico = isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico';
        $tecnicoId = $isTecnico ? ($_SESSION['user_id'] ?? null) : null;

        $vistoriasAndamentoList = Vistoria::byStatusWithDetails('Em Andamento', $tecnicoId);
        $vistoriasConcluidasList = Vistoria::byStatusWithDetails('Concluído', $tecnicoId);
        $vistoriasCanceladasList = Vistoria::byStatusWithDetails('Cancelado', $tecnicoId);

        // Agendamentos de hoje
        $hoje = date('Y-m-d');
        $agendadosHoje = Vistoria::getScheduledForDate($hoje, $tecnicoId);

        // Todos os serviços para alimentar dinamicamente o calendário do mês/ano
        $todosServicos = Vistoria::allWithDetails($tecnicoId);

        $veiculosAtivosCount = count(array_filter($veiculos, fn($v) => !empty($v['ativo'])));
        $servicosRealizadosCount = count($vistoriasConcluidasList);

        $data = [
            'pageTitle' => 'Dashboard Operacional',
            'veiculosCount' => $veiculosAtivosCount,
            'servicosRealizadosCount' => $servicosRealizadosCount,
            'totalAgendadosHoje' => count($agendadosHoje),
            'vistoriasAndamento' => count($vistoriasAndamentoList),
            'vistoriasConcluidas' => count($vistoriasConcluidasList),
            'vistoriasCanceladas' => count($vistoriasCanceladasList),
            'veiculos' => $veiculos,
            'vistoriasAndamentoList' => $vistoriasAndamentoList,
            'vistoriasConcluidasList' => $vistoriasConcluidasList,
            'vistoriasCanceladasList' => $vistoriasCanceladasList,
            'agendadosHoje' => $agendadosHoje,
            'todosServicos' => $todosServicos,
            'isTecnico' => $isTecnico,
            'dataHoje' => $hoje
        ];

        $this->view('layout/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('layout/footer');
    }
}
