<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Database;

class VeiculoController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM veiculos ORDER BY data_criacao DESC";
        $veiculos = $db->query($query)->fetchAll();

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

        $db = Database::getInstance()->getConnection();
        $itens = $db->query("SELECT * FROM itens_reparo ORDER BY tipo_reparo, classificacao_vidro")->fetchAll();

        $data = [
            'pageTitle' => 'Novo Veículo',
            'itens' => $itens
        ];

        $this->view('layout/header', $data);
        $this->view('veiculos/novo', $data);
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO veiculos (placa, chassi, fabricante, modelo, ano_fabricacao, tipo_veiculo, nome_proprietario, telefone_proprietario, item_reparo_id) 
                VALUES (:placa, :chassi, :fabricante, :modelo, :ano, :tipo, :proprietario, :telefone, :item_id)
            ");
            $stmt->execute([
                ':placa' => $_POST['placa'],
                ':chassi' => $_POST['chassi'] ?? null,
                ':fabricante' => $_POST['fabricante'] ?? null,
                ':modelo' => $_POST['modelo'] ?? null,
                ':ano' => $_POST['ano_fabricacao'] ?? null,
                ':tipo' => $_POST['tipo_veiculo'],
                ':proprietario' => $_POST['nome_proprietario'] ?? null,
                ':telefone' => $_POST['telefone_proprietario'] ?? null,
                ':item_id' => !empty($_POST['item_reparo_id']) ? $_POST['item_reparo_id'] : null
            ]);
            $this->redirect('/veiculos');
        }
    }
}
