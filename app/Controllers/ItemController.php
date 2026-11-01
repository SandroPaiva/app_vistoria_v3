<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\ItemReparo;

class ItemController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $itens = ItemReparo::all();

        $data = [
            'pageTitle' => 'Itens de Serviço',
            'itens' => $itens
        ];

        $this->view('layout/header', $data);
        $this->view('itens/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $data = ['pageTitle' => 'Novo Item de Serviço'];
        $this->view('layout/header', $data);
        $this->view('itens/novo');
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ItemReparo::create([
                'tipo_reparo' => $_POST['tipo_reparo'] ?? '',
                'classificacao_vidro' => $_POST['classificacao_vidro'] ?? '',
                'especificacao_outros' => $_POST['especificacao_outros'] ?? null,
                'ativo' => isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1
            ]);
            $this->redirect('/itens');
        }
    }

    public function edit($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        $item = ItemReparo::findById((int)$id);

        if (!$item) {
            die("Item de reparo não encontrado.");
        }

        $data = [
            'pageTitle' => 'Editar Item de Serviço',
            'item' => $item
        ];

        $this->view('layout/header', $data);
        $this->view('itens/editar', $data);
        $this->view('layout/footer');
    }

    public function update() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            ItemReparo::update($id, [
                'tipo_reparo' => $_POST['tipo_reparo'] ?? '',
                'classificacao_vidro' => $_POST['classificacao_vidro'] ?? '',
                'especificacao_outros' => $_POST['especificacao_outros'] ?? null,
                'ativo' => isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1
            ]);
            $this->redirect('/itens');
        }
    }

    public function deactivate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        ItemReparo::deactivate((int)$id);

        $this->redirect('/itens');
    }

    public function activate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente', 'Supervisor']);

        ItemReparo::activate((int)$id);

        $this->redirect('/itens');
    }
}
