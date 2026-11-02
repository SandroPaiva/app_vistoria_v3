<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Usuario;

class PerfilController extends Controller {
    
    /**
     * Exibe o perfil completo do usuário logado
     */
    public function index() {
        $this->requireLogin();

        $userId = (int)$_SESSION['user_id'];
        $user = Usuario::findById($userId);

        if (!$user) {
            $this->redirect('/logout');
        }

        $data = [
            'pageTitle' => 'Meu Perfil',
            'user' => $user
        ];

        $this->view('layout/header', $data);
        $this->view('perfil/index', $data);
        $this->view('layout/footer');
    }

    /**
     * Processa a alteração de nome do próprio usuário
     */
    public function updateNome() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = (int)$_SESSION['user_id'];
            $novoNome = trim($_POST['nome_completo'] ?? '');

            if (empty($novoNome)) {
                $_SESSION['flash_error'] = 'O nome completo não pode ser vazio.';
                $this->redirect('/perfil');
            }

            if (mb_strlen($novoNome) < 3) {
                $_SESSION['flash_error'] = 'O nome deve conter pelo menos 3 caracteres.';
                $this->redirect('/perfil');
            }

            $updated = Usuario::updateName($userId, $novoNome);

            if ($updated) {
                // Atualiza o nome na sessão para refletir imediatamente em todo o sistema
                $_SESSION['user_name'] = $novoNome;
                $_SESSION['flash_success'] = 'Seu nome foi alterado com sucesso!';
            } else {
                $_SESSION['flash_error'] = 'Erro ao atualizar o nome. Tente novamente.';
            }

            $this->redirect('/perfil');
        }

        $this->redirect('/perfil');
    }

    /**
     * Exibe a tela de troca de senha
     */
    public function senha() {
        $this->requireLogin();

        $userId = (int)$_SESSION['user_id'];
        $user = Usuario::findById($userId);

        $data = [
            'pageTitle' => 'Trocar Senha',
            'user' => $user
        ];

        $this->view('layout/header', $data);
        $this->view('perfil/senha', $data);
        $this->view('layout/footer');
    }

    /**
     * Processa a alteração de senha seguindo as regras de segurança:
     * 1. Inserção obrigatória da senha atual
     * 2. Inserção dupla da nova senha com conferência
     */
    public function updateSenha() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = (int)$_SESSION['user_id'];
            $user = Usuario::findById($userId);

            if (!$user) {
                $this->redirect('/logout');
            }

            $senhaAtual = $_POST['senha_atual'] ?? '';
            $novaSenha = $_POST['nova_senha'] ?? '';
            $confirmarSenha = $_POST['confirmar_senha'] ?? '';

            // 1. Validação de preenchimento de todos os campos
            if (empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
                $_SESSION['flash_error'] = 'Por favor, preencha todos os campos de senha.';
                $this->redirect('/perfil/senha');
            }

            // 2. Validação da senha atual informada
            if (!password_verify($senhaAtual, $user['senha_hash'])) {
                $_SESSION['flash_error'] = 'A senha atual informada está incorreta. Verifique e tente novamente.';
                $this->redirect('/perfil/senha');
            }

            // 3. Validação do tamanho mínimo da nova senha
            if (strlen($novaSenha) < 6) {
                $_SESSION['flash_error'] = 'A nova senha deve ter no mínimo 6 caracteres.';
                $this->redirect('/perfil/senha');
            }

            // 4. Validação da conferência da nova senha inserida duas vezes
            if ($novaSenha !== $confirmarSenha) {
                $_SESSION['flash_error'] = 'A nova senha e a confirmação de senha não conferem. Digite exatamente a mesma senha nos dois campos.';
                $this->redirect('/perfil/senha');
            }

            // 5. Verificação para evitar que a nova senha seja idêntica à anterior
            if (password_verify($novaSenha, $user['senha_hash'])) {
                $_SESSION['flash_error'] = 'A nova senha não pode ser igual à sua senha atual. Escolha uma senha diferente.';
                $this->redirect('/perfil/senha');
            }

            // Criptografa e salva a nova senha
            $novoHash = password_hash($novaSenha, PASSWORD_BCRYPT);
            $updated = Usuario::updatePassword($userId, $novoHash);

            if ($updated) {
                $_SESSION['flash_success'] = 'Sua senha foi alterada com sucesso!';
                $this->redirect('/perfil/senha');
            } else {
                $_SESSION['flash_error'] = 'Ocorreu um erro ao atualizar a senha no banco de dados. Tente novamente.';
                $this->redirect('/perfil/senha');
            }
        }

        $this->redirect('/perfil/senha');
    }
}
