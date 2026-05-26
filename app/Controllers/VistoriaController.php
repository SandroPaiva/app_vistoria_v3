<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Database;

class VistoriaController extends Controller {
    public function index() {
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT v.*, ve.placa, ve.fabricante, ve.modelo 
                  FROM vistorias v 
                  JOIN veiculos ve ON v.veiculo_id = ve.id
                  ORDER BY v.data_criacao DESC";
                  
        $vistorias = $db->query($query)->fetchAll();

        $data = [
            'pageTitle' => 'Histórico de Reparos (Vistorias)',
            'vistorias' => $vistorias
        ];

        $this->view('layout/header', $data);
        $this->view('vistorias/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();
        $veiculos = $db->query("SELECT id, placa, fabricante, modelo FROM veiculos ORDER BY placa")->fetchAll();
        $tecnicos = $db->query("SELECT id, nome_completo FROM usuarios WHERE perfil_acesso = 'Técnico' ORDER BY nome_completo")->fetchAll();

        $data = [
            'pageTitle' => 'Nova Vistoria',
            'veiculos' => $veiculos,
            'tecnicos' => $tecnicos
        ];

        $this->view('layout/header', $data);
        $this->view('vistorias/nova', $data);
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO vistorias (veiculo_id, tecnico_id, status) 
                VALUES (:veiculo_id, :tecnico_id, 'Em Andamento')
            ");
            
            $stmt->execute([
                ':veiculo_id' => $_POST['veiculo_id'],
                ':tecnico_id' => $_POST['tecnico_id']
            ]);
            
            $vistoria_id = $db->lastInsertId();
            $this->redirect('/vistorias'); // or redirect to execution page directly
        }
    }

    public function execute($id) {
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT v.*, ve.placa, ve.modelo, ve.fabricante, ir.tipo_reparo, ir.classificacao_vidro 
            FROM vistorias v
            JOIN veiculos ve ON v.veiculo_id = ve.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE v.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $vistoria = $stmt->fetch();

        if (!$vistoria) {
            die("Vistoria não encontrada.");
        }

        // Técnicos só podem acessar suas próprias vistorias
        if ($_SESSION['user_profile'] === 'Técnico' && $vistoria['tecnico_id'] != $_SESSION['user_id']) {
            die("Acesso negado. Esta vistoria pertence a outro técnico.");
        }

        $data = [
            'pageTitle' => 'Execução do Reparo - Vistoria #' . $vistoria['id'],
            'vistoria' => $vistoria
        ];

        $this->view('layout/header', $data);
        $this->view('vistorias/executar', $data);
        $this->view('layout/footer');
    }

    public function saveStep() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Verifica se o upload excedeu o post_max_size silenciosamente
            if (empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
                die("Erro crítico: As fotos enviadas excedem o limite de tamanho permitido pelo servidor. Tente enviar menos fotos de cada vez ou tire fotos com menor resolução.");
            }

            $vistoria_id = $_POST['vistoria_id'];
            $dados_reparo = $_POST['dados_reparo'] ?? '';
            $assinatura = $_POST['assinatura_digital'] ?? '';
            $status = $_POST['finalizar'] === '1' ? 'Concluído' : 'Em Andamento';
            
            // Geolocalização
            $lat = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
            $lng = !empty($_POST['longitude']) ? $_POST['longitude'] : null;

            $db = Database::getInstance()->getConnection();

            // Atualiza os dados principais
            $stmt = $db->prepare("
                UPDATE vistorias 
                SET dados_reparo = :dados, assinatura_digital = :assinatura, status = :status,
                    latitude = :lat, longitude = :lng, data_fim = " . ($status === 'Concluído' ? "CURRENT_TIMESTAMP" : "NULL") . "
                WHERE id = :id
            ");
            $stmt->execute([
                ':dados' => $dados_reparo,
                ':assinatura' => $assinatura,
                ':status' => $status,
                ':lat' => $lat,
                ':lng' => $lng,
                ':id' => $vistoria_id
            ]);

            // Tratar Upload de Fotos via Base64 do Front-end
            $uploadDir = BASE_PATH . '/public/assets/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
                chmod($uploadDir, 0777); // Força as permissões caso o umask do servidor seja restritivo
            }

            // Mapeamento dos nomes do JS para os tipos no banco de dados
            $mapeamentoFotos = [
                'pre_reparo' => 'Pre-Reparo',
                'pos_reparo' => 'Pos-Reparo',
                'item_antes' => 'Item-Antes',
                'item_depois' => 'Item-Depois'
            ];

            foreach ($mapeamentoFotos as $postKey => $dbTipo) {
                $base64Array = $_POST['base64_' . $postKey] ?? [];
                
                foreach ($base64Array as $base64String) {
                    // O formato do base64 é "data:image/jpeg;base64,/9j/4AAQSkZJR..."
                    $parts = explode(',', $base64String);
                    if (count($parts) === 2) {
                        $imgData = base64_decode($parts[1]);
                        $fileName = time() . '_' . rand(1000, 9999) . '_' . $postKey . '.jpg';
                        $destPath = $uploadDir . $fileName;

                        if (file_put_contents($destPath, $imgData)) {
                            // Garante que a foto salva possa ser lida depois
                            chmod($destPath, 0666);
                            $stmtFoto = $db->prepare("INSERT INTO fotos_vistoria (vistoria_id, tipo_foto, caminho_arquivo) VALUES (?, ?, ?)");
                            $stmtFoto->execute([$vistoria_id, $dbTipo, '/assets/img/' . $fileName]);
                        }
                    }
                }
            }

            $this->redirect('/vistorias');
        }
    }

    public function pdf($id) {
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();
        
        // Fetch Vistoria and related data
        $stmt = $db->prepare("
            SELECT v.*, ve.placa, ve.chassi, ve.fabricante, ve.modelo, ve.ano_fabricacao, ve.nome_proprietario, 
                   ir.tipo_reparo, ir.classificacao_vidro, ir.especificacao_outros,
                   u.nome_completo as nome_tecnico
            FROM vistorias v
            JOIN veiculos ve ON v.veiculo_id = ve.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            JOIN usuarios u ON v.tecnico_id = u.id
            WHERE v.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $vistoria = $stmt->fetch();

        if (!$vistoria) {
            die("Vistoria não encontrada.");
        }

        // Fetch Fotos
        $stmtFotos = $db->prepare("SELECT * FROM fotos_vistoria WHERE vistoria_id = :id ORDER BY tipo_foto");
        $stmtFotos->execute([':id' => $id]);
        $fotos = $stmtFotos->fetchAll();

        // Organize Fotos
        $fotosOrganizadas = [
            'Pre-Reparo' => [],
            'Pos-Reparo' => [],
            'Item-Antes' => [],
            'Item-Depois' => []
        ];
        
        foreach ($fotos as $f) {
            if (isset($fotosOrganizadas[$f['tipo_foto']])) {
                $fotosOrganizadas[$f['tipo_foto']][] = $f;
            }
        }

        $data = [
            'pageTitle' => 'Relatório de Vistoria #' . $vistoria['id'],
            'vistoria' => $vistoria,
            'fotos' => $fotosOrganizadas
        ];

        // This view will be specifically styled for printing (A4 format)
        $this->view('vistorias/pdf', $data);
    }
}
