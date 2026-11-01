<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Usuario;

class UsuarioController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $userProfile = $_SESSION['user_profile'] ?? null;
        $usuarios = Usuario::all($userProfile);

        $data = [
            'pageTitle' => 'Gerenciamento de Usuários',
            'usuarios' => $usuarios
        ];

        $this->view('layout/header', $data);
        $this->view('usuarios/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $data = ['pageTitle' => 'Novo Usuário'];
        $this->view('layout/header', $data);
        $this->view('usuarios/novo', $data);
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gerente só pode cadastrar Supervisor e Técnico
            $perfil = $_POST['perfil_acesso'] ?? '';
            if ($_SESSION['user_profile'] === 'Gerente' && in_array($perfil, ['Administrador', 'Gerente'])) {
                die("Permissão negada para cadastrar este perfil.");
            }

            $senha_hash = password_hash($_POST['senha'] ?? '', PASSWORD_BCRYPT);

            Usuario::create([
                'nome_completo' => $_POST['nome_completo'] ?? '',
                'email' => $_POST['email'] ?? '',
                'login' => $_POST['login'] ?? '',
                'senha_hash' => $senha_hash,
                'perfil_acesso' => $perfil,
                'ativo' => isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1
            ]);

            $this->redirect('/usuarios');
        }
    }

    public function edit($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $usuario = Usuario::findById((int)$id, false);

        if (!$usuario) {
            die("Usuário não encontrado.");
        }

        // Gerente só pode editar Supervisor e Técnico
        if ($_SESSION['user_profile'] === 'Gerente' && in_array($usuario['perfil_acesso'], ['Administrador', 'Gerente'])) {
            die("Permissão negada.");
        }

        $data = [
            'pageTitle' => 'Editar Usuário',
            'usuario' => $usuario
        ];

        $this->view('layout/header', $data);
        $this->view('usuarios/editar', $data);
        $this->view('layout/footer');
    }

    public function update() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $perfil = $_POST['perfil_acesso'] ?? '';

            // Gerente só pode atualizar Supervisor e Técnico
            if ($_SESSION['user_profile'] === 'Gerente' && in_array($perfil, ['Administrador', 'Gerente'])) {
                die("Permissão negada.");
            }

            $updateData = [
                'nome_completo' => $_POST['nome_completo'] ?? '',
                'email' => $_POST['email'] ?? '',
                'login' => $_POST['login'] ?? '',
                'perfil_acesso' => $perfil
            ];

            if (isset($_POST['ativo'])) {
                $updateData['ativo'] = (int)$_POST['ativo'];
            }

            if (!empty($_POST['senha'])) {
                $updateData['senha_hash'] = password_hash($_POST['senha'], PASSWORD_BCRYPT);
            }

            Usuario::update($id, $updateData);

            $this->redirect('/usuarios');
        }
    }

    public function deactivate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $id = (int)$id;
        if ($_SESSION['user_id'] == $id) {
            die("Você não pode desativar o seu próprio usuário.");
        }

        $usuario = Usuario::findById($id);

        if ($usuario) {
            if ($_SESSION['user_profile'] === 'Gerente' && in_array($usuario['perfil_acesso'], ['Administrador', 'Gerente'])) {
                die("Permissão negada.");
            }

            Usuario::deactivate($id);
        }

        $this->redirect('/usuarios');
    }

    public function activate($id) {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $id = (int)$id;
        $usuario = Usuario::findById($id);

        if ($usuario) {
            if ($_SESSION['user_profile'] === 'Gerente' && in_array($usuario['perfil_acesso'], ['Administrador', 'Gerente'])) {
                die("Permissão negada.");
            }

            Usuario::activate($id);
        }

        $this->redirect('/usuarios');
    }
}
