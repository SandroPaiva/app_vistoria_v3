<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Database;

class DashboardController extends Controller {
    public function index() {
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();

        // KPIs
        $veiculosCount = $db->query("SELECT COUNT(*) FROM veiculos")->fetchColumn();
        $vistoriasAndamento = $db->query("SELECT COUNT(*) FROM vistorias WHERE status = 'Em Andamento'")->fetchColumn();
        $vistoriasConcluidas = $db->query("SELECT COUNT(*) FROM vistorias WHERE status = 'Concluído'")->fetchColumn();
        $vistoriasCanceladas = $db->query("SELECT COUNT(*) FROM vistorias WHERE status = 'Cancelado'")->fetchColumn();

        $data = [
            'pageTitle' => 'Dashboard Operacional',
            'veiculosCount' => $veiculosCount,
            'vistoriasAndamento' => $vistoriasAndamento,
            'vistoriasConcluidas' => $vistoriasConcluidas,
            'vistoriasCanceladas' => $vistoriasCanceladas
        ];

        $this->view('layout/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('layout/footer');
    }
}
