<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Database;

class ItemController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM itens_reparo ORDER BY tipo_reparo, classificacao_vidro";
        $itens = $db->query($query)->fetchAll();

        $data = [
            'pageTitle' => 'Itens de Reparo',
            'itens' => $itens
        ];

        $this->view('layout/header', $data);
        $this->view('itens/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $data = ['pageTitle' => 'Novo Item de Reparo'];
        $this->view('layout/header', $data);
        $this->view('itens/novo');
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO itens_reparo (tipo_reparo, classificacao_vidro, especificacao_outros) VALUES (:tipo, :classificacao, :especificacao)");
            $stmt->execute([
                ':tipo' => $_POST['tipo_reparo'],
                ':classificacao' => $_POST['classificacao_vidro'],
                ':especificacao' => $_POST['especificacao_outros'] ?? null
            ]);
            $this->redirect('/itens');
        }
    }
}
