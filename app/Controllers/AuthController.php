<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Usuario;

class AuthController extends Controller {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = trim($_POST['login'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $user = Usuario::findByLogin($login);

            if ($user && password_verify($senha, $user['senha_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome_completo'];
                $_SESSION['user_profile'] = $user['perfil_acesso'];
                $this->redirect('/dashboard');
            } else {
                $error = "Credenciais inválidas.";
                $this->view('auth/login', ['error' => $error]);
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
