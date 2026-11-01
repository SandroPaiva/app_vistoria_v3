<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Veiculo;
use app\Models\ItemReparo;
use app\Models\Usuario;
use app\Models\Vistoria;

class VeiculoController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $veiculos = Veiculo::allWithItem();

        $data = [
            'pageTitle' => 'Gerenciamento de Veículos',
            'veiculos' => $veiculos
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $itens = ItemReparo::allActive();
        $tecnicos = Usuario::getActiveTecnicos();

        $data = [
            'pageTitle' => 'Novo Veículo',
            'itens' => $itens,
            'tecnicos' => $tecnicos
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/novo', $data);
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataAgendamento = !empty($_POST['data_agendamento']) ? $_POST['data_agendamento'] : null;
            $tecnicoAgendadoId = !empty($_POST['tecnico_agendado_id']) ? (int)$_POST['tecnico_agendado_id'] : null;

            $veiculoId = Veiculo::create([
                'placa' => strtoupper(trim($_POST['placa'] ?? '')),
                'chassi' => strtoupper(trim($_POST['chassi'] ?? '')) ?: null,
                'fabricante' => trim($_POST['fabricante'] ?? '') ?: null,
                'modelo' => trim($_POST['modelo'] ?? '') ?: null,
                'ano_fabricacao' => !empty($_POST['ano_fabricacao']) ? (int)$_POST['ano_fabricacao'] : null,
                'tipo_veiculo' => $_POST['tipo_veiculo'] ?? 'Carro',
                'nome_proprietario' => trim($_POST['nome_proprietario'] ?? '') ?: null,
                'telefone_proprietario' => trim($_POST['telefone_proprietario'] ?? '') ?: null,
                'item_reparo_id' => !empty($_POST['item_reparo_id']) ? (int)$_POST['item_reparo_id'] : null,
                'data_agendamento' => $dataAgendamento,
                'tecnico_agendado_id' => $tecnicoAgendadoId,
                'ativo' => 1
            ]);

            // Se o usuário agendou um serviço no cadastro do veículo, cria a vistoria agendada correspondente
            if ($veiculoId && $dataAgendamento && $tecnicoAgendadoId) {
                Vistoria::create(
                    $veiculoId,
                    $tecnicoAgendadoId,
                    $dataAgendamento,
                    'Agendado',
                    'Primeiro Serviço',
                    'Serviço agendado no cadastro inicial do veículo.'
                );
            }

            $this->redirect('/veiculos');
        }
    }

    public function edit($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $veiculo = Veiculo::findById((int)$id);

        if (!$veiculo) {
            die("Veículo não encontrado.");
        }

        $itens = ItemReparo::allActive();
        $tecnicos = Usuario::getActiveTecnicos();

        $data = [
            'pageTitle' => 'Editar Veículo',
            'veiculo' => $veiculo,
            'itens' => $itens,
            'tecnicos' => $tecnicos
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/editar', $data);
        $this->view('layout/footer');
    }

    public function update() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $dataAgendamento = !empty($_POST['data_agendamento']) ? $_POST['data_agendamento'] : null;
            $tecnicoAgendadoId = !empty($_POST['tecnico_agendado_id']) ? (int)$_POST['tecnico_agendado_id'] : null;

            Veiculo::update($id, [
                'placa' => strtoupper(trim($_POST['placa'] ?? '')),
                'chassi' => strtoupper(trim($_POST['chassi'] ?? '')) ?: null,
                'fabricante' => trim($_POST['fabricante'] ?? '') ?: null,
                'modelo' => trim($_POST['modelo'] ?? '') ?: null,
                'ano_fabricacao' => !empty($_POST['ano_fabricacao']) ? (int)$_POST['ano_fabricacao'] : null,
                'tipo_veiculo' => $_POST['tipo_veiculo'] ?? 'Carro',
                'nome_proprietario' => trim($_POST['nome_proprietario'] ?? '') ?: null,
                'telefone_proprietario' => trim($_POST['telefone_proprietario'] ?? '') ?: null,
                'item_reparo_id' => !empty($_POST['item_reparo_id']) ? (int)$_POST['item_reparo_id'] : null,
                'data_agendamento' => $dataAgendamento,
                'tecnico_agendado_id' => $tecnicoAgendadoId,
                'ativo' => isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1
            ]);

            // Se definiu agendamento na edição e o veículo não possui vistoria agendada futura, registra
            if ($dataAgendamento && $tecnicoAgendadoId) {
                $proximo = Vistoria::getNextScheduledByVeiculoId($id);
                if (!$proximo) {
                    Vistoria::create(
                        $id,
                        $tecnicoAgendadoId,
                        $dataAgendamento,
                        'Agendado',
                        'Primeiro Serviço',
                        'Serviço agendado na edição do veículo.'
                    );
                }
            }

            $this->redirect('/veiculos');
        }
    }

    public function deactivate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        Veiculo::deactivate((int)$id);
        $this->redirect('/veiculos');
    }

    public function activate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        Veiculo::activate((int)$id);
        $this->redirect('/veiculos');
    }

    public function show($id) {
        $this->requireLogin();

        $id = (int)$id;
        $veiculo = Veiculo::findByIdWithItem($id);

        if (!$veiculo) {
            die("Veículo não encontrado.");
        }

        $proximoAgendado = Vistoria::getNextScheduledByVeiculoId($id);
        $historicoServicos = Vistoria::getHistoryByVeiculoId($id);

        $data = [
            'pageTitle' => 'Histórico e Dados do Veículo',
            'veiculo' => $veiculo,
            'proximoAgendado' => $proximoAgendado,
            'historicoServicos' => $historicoServicos
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/visualizar', $data);
        $this->view('layout/footer');
    }

    public function novoServicoForm($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $id = (int)$id;
        $veiculo = Veiculo::findByIdWithItem($id);

        if (!$veiculo) {
            die("Veículo não encontrado.");
        }

        $itens = ItemReparo::allActive();
        $tecnicos = Usuario::getActiveTecnicos();
        $historico = Vistoria::getHistoryByVeiculoId($id);

        $data = [
            'pageTitle' => 'Registrar Novo Serviço / Refazer',
            'veiculo' => $veiculo,
            'itens' => $itens,
            'tecnicos' => $tecnicos,
            'historico' => $historico
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/novo_servico', $data);
        $this->view('layout/footer');
    }

    public function storeNovoServico() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $veiculoId = (int)($_POST['veiculo_id'] ?? 0);
            $tecnicoId = (int)($_POST['tecnico_id'] ?? 0);
            $motivo = trim($_POST['motivo_servico'] ?? '');
            $observacao = trim($_POST['observacao_motivo'] ?? '');
            $itemReparoId = !empty($_POST['item_reparo_id']) ? (int)$_POST['item_reparo_id'] : null;
            $dataAgendamento = !empty($_POST['data_agendamento']) ? $_POST['data_agendamento'] : null;

            if (empty($motivo) || !in_array($motivo, ['Novo Serviço', 'Refazer'])) {
                die("Erro: O motivo do serviço ('Novo Serviço' ou 'Refazer') é obrigatório.");
            }

            if (empty($observacao)) {
                die("Erro: A observação complementar é estritamente obrigatória para novos serviços ou retrabalhos.");
            }

            if (!$veiculoId || !$tecnicoId) {
                die("Erro: Veículo e Técnico são obrigatórios.");
            }

            // Atualiza o item de reparo e agendamento no veículo se fornecido
            if ($itemReparoId) {
                Veiculo::update($veiculoId, [
                    'item_reparo_id' => $itemReparoId,
                    'data_agendamento' => $dataAgendamento,
                    'tecnico_agendado_id' => $tecnicoId,
                    'placa' => $_POST['veiculo_placa'] ?? '',
                    'tipo_veiculo' => $_POST['veiculo_tipo'] ?? 'Carro'
                ]);
            }

            $status = !empty($dataAgendamento) ? 'Agendado' : 'Em Andamento';

            Vistoria::create(
                $veiculoId,
                $tecnicoId,
                $dataAgendamento,
                $status,
                $motivo,
                $observacao
            );

            $this->redirect('/veiculos/visualizar/' . $veiculoId);
        }
    }
}
