<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Database;

class UsuarioController extends Controller {
    public function index() {
        $this->requireLogin();
        $this->hasPermission(['Administrador', 'Gerente']);

        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM usuarios";
        if ($_SESSION['user_profile'] === 'Gerente') {
            $query .= " WHERE perfil_acesso IN ('Supervisor', 'Técnico')";
        }
        $query .= " ORDER BY nome_completo";
        
        $usuarios = $db->query($query)->fetchAll();

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
            $perfil = $_POST['perfil_acesso'];
            if ($_SESSION['user_profile'] === 'Gerente' && in_array($perfil, ['Administrador', 'Gerente'])) {
                die("Permissão negada para cadastrar este perfil.");
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO usuarios (nome_completo, email, login, senha_hash, perfil_acesso) 
                VALUES (:nome, :email, :login, :senha, :perfil)
            ");
            
            $senha_hash = password_hash($_POST['senha'], PASSWORD_BCRYPT);

            $stmt->execute([
                ':nome' => $_POST['nome_completo'],
                ':email' => $_POST['email'],
                ':login' => $_POST['login'],
                ':senha' => $senha_hash,
                ':perfil' => $perfil
            ]);
            $this->redirect('/usuarios');
        }
    }
}
