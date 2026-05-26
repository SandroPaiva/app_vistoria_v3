<?php
session_start();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $scriptDir === '/' || $scriptDir === '\\' ? '' : $scriptDir);

// Autoloader simples
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = BASE_PATH . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load Router
require_php_files(APP_PATH . '/Core');

// Helper para requerir arquivos
function require_php_files($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                require_php_files($path);
            } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                require_once $path;
            }
        }
    }
}

use app\Core\Router;

$router = new Router();

// Routes
$router->get('/', 'DashboardController@index');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

// Dashboard Routes
$router->get('/dashboard', 'DashboardController@index');

// Vistoria Routes
$router->get('/vistorias', 'VistoriaController@index');
$router->get('/vistorias/nova', 'VistoriaController@create');
$router->post('/vistorias/store', 'VistoriaController@store');
$router->get('/vistorias/executar/{id}', 'VistoriaController@execute');
$router->post('/vistorias/salvar_etapa', 'VistoriaController@saveStep');
$router->get('/vistorias/pdf/{id}', 'VistoriaController@pdf');

// Usuarios
$router->get('/usuarios', 'UsuarioController@index');
$router->get('/usuarios/novo', 'UsuarioController@create');
$router->post('/usuarios/store', 'UsuarioController@store');

// Veiculos
$router->get('/veiculos', 'VeiculoController@index');
$router->get('/veiculos/novo', 'VeiculoController@create');
$router->post('/veiculos/store', 'VeiculoController@store');

// Itens de Reparo
$router->get('/itens', 'ItemController@index');
$router->get('/itens/novo', 'ItemController@create');
$router->post('/itens/store', 'ItemController@store');

// Dispatch
$url = isset($_GET['url']) ? $_GET['url'] : (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');
$router->dispatch($url);
