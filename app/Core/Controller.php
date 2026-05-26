<?php

namespace app\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = APP_PATH . '/Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View does not exist: " . $viewFile);
        }
    }

    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    protected function hasPermission($allowedProfiles) {
        if (!isset($_SESSION['user_profile']) || !in_array($_SESSION['user_profile'], $allowedProfiles)) {
            die("Acesso Negado."); // In a real app, show a nice 403 page
        }
    }
}
