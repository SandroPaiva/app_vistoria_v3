<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Vistoria;
use app\Models\FotoVistoria;
use app\Models\Veiculo;
use app\Models\Usuario;

class VistoriaController extends Controller {
    public function index() {
        $this->requireLogin();

        $isTecnico = isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico';
        $tecnicoId = $isTecnico ? ($_SESSION['user_id'] ?? null) : null;

        $hoje = date('Y-m-d');
        $agendadosHoje = Vistoria::getScheduledForDate($hoje, $tecnicoId);
        $vistorias = Vistoria::allWithDetails($tecnicoId);

        $data = [
            'pageTitle' => 'Histórico e Gestão de Serviços',
            'vistorias' => $vistorias,
            'agendadosHoje' => $agendadosHoje,
            'isTecnico' => $isTecnico
        ];

        $this->view('layout/header', $data);
        $this->view('vistorias/index', $data);
        $this->view('layout/footer');
    }

    public function create() {
        $this->requireLogin();

        $isTecnico = isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico';

        // Técnicos não iniciam serviços livres; operam estritamente através do quadro de agendamentos
        if ($isTecnico) {
            $this->redirect('/vistorias');
        }

        // Apenas veículos que NÃO possuem nenhum serviço registrado (em andamento, cancelado ou concluído)
        $veiculos = Veiculo::availableForNewService();
        $tecnicos = Usuario::getActiveTecnicos();

        $data = [
            'pageTitle' => 'Iniciar Novo Serviço',
            'veiculos' => $veiculos,
            'tecnicos' => $tecnicos
        ];

        $this->view('layout/header', $data);
        $this->view('vistorias/nova', $data);
        $this->view('layout/footer');
    }

    public function store() {
        $this->requireLogin();

        $isTecnico = isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico';
        if ($isTecnico) {
            $this->redirect('/vistorias');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tecnico_id = (int)($_POST['tecnico_id'] ?? 0);
            $veiculo_id = (int)($_POST['veiculo_id'] ?? 0);
            $dataAgendamento = !empty($_POST['data_agendamento']) ? $_POST['data_agendamento'] : null;
            $status = !empty($dataAgendamento) ? 'Agendado' : 'Em Andamento';

            Vistoria::create($veiculo_id, $tecnico_id, $dataAgendamento, $status, 'Primeiro Serviço');

            $this->redirect('/vistorias');
        }
    }

    public function startScheduled($id) {
        $this->requireLogin();

        $id = (int)$id;
        $vistoria = Vistoria::findByIdWithDetails($id);

        if (!$vistoria) {
            die("Serviço não encontrado.");
        }

        if (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $vistoria['tecnico_id'] != $_SESSION['user_id']) {
            die("Acesso negado. Este serviço pertence a outro técnico.");
        }

        // Atualiza status para 'Em Andamento' e define data_inicio
        Vistoria::startService($id);

        $this->redirect('/vistorias/executar/' . $id);
    }

    public function execute($id) {
        $this->requireLogin();

        $id = (int)$id;
        $vistoria = Vistoria::findByIdWithDetails($id);

        if (!$vistoria) {
            die("Vistoria não encontrada.");
        }

        // Técnicos só podem acessar suas próprias vistorias
        if (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $vistoria['tecnico_id'] != $_SESSION['user_id']) {
            die("Acesso negado. Esta vistoria pertence a outro técnico.");
        }

        $data = [
            'pageTitle' => 'Execução de Serviço - #' . $vistoria['id'],
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

            $vistoria_id = (int)($_POST['vistoria_id'] ?? 0);
            $tecnico_id = Vistoria::findTecnicoId($vistoria_id);

            if ($tecnico_id === null) {
                die("Vistoria não encontrada.");
            }

            if (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $tecnico_id != $_SESSION['user_id']) {
                die("Acesso negado. Esta vistoria pertence a outro técnico.");
            }

            $dados_reparo = $_POST['dados_reparo'] ?? '';
            $assinatura = $_POST['assinatura_digital'] ?? '';
            $status = (isset($_POST['finalizar']) && $_POST['finalizar'] === '1') ? 'Concluído' : 'Em Andamento';
            
            // Geolocalização
            $lat = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
            $lng = !empty($_POST['longitude']) ? $_POST['longitude'] : null;

            // Atualiza os dados principais da vistoria
            Vistoria::saveExecution($vistoria_id, [
                'dados_reparo' => $dados_reparo,
                'assinatura_digital' => $assinatura,
                'status' => $status,
                'latitude' => $lat,
                'longitude' => $lng
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
                    $parts = explode(',', $base64String);
                    if (count($parts) === 2) {
                        $imgData = base64_decode($parts[1]);
                        $fileName = time() . '_' . rand(1000, 9999) . '_' . $postKey . '.jpg';
                        $destPath = $uploadDir . $fileName;

                        if (file_put_contents($destPath, $imgData)) {
                            chmod($destPath, 0666);
                            FotoVistoria::create($vistoria_id, $dbTipo, '/assets/img/' . $fileName);
                        }
                    }
                }
            }

            $this->redirect('/vistorias');
        }
    }

    public function pdf($id) {
        $this->requireLogin();

        $id = (int)$id;
        $vistoria = Vistoria::findByIdWithDetails($id);

        if (!$vistoria) {
            die("Vistoria não encontrada.");
        }

        // Técnicos só podem acessar suas próprias vistorias
        if (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $vistoria['tecnico_id'] != $_SESSION['user_id']) {
            die("Acesso negado. Esta vistoria pertence a outro técnico.");
        }

        // Fetch Fotos
        $fotos = FotoVistoria::getByVistoriaId($id);

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
            'pageTitle' => 'Relatório de Serviço #' . $vistoria['id'],
            'vistoria' => $vistoria,
            'fotos' => $fotosOrganizadas
        ];

        // This view will be specifically styled for printing (A4 format)
        $this->view('vistorias/pdf', $data);
    }

    public function cancel($id) {
        $this->requireLogin();

        $id = (int)$id;
        $tecnico_id = Vistoria::findTecnicoId($id);

        if ($tecnico_id === null) {
            die("Serviço não encontrado.");
        }

        // Técnicos só podem cancelar seus próprios serviços
        if (isset($_SESSION['user_profile']) && $_SESSION['user_profile'] === 'Técnico' && $tecnico_id != $_SESSION['user_id']) {
            die("Acesso negado. Este serviço pertence a outro técnico.");
        }

        $motivo = $_GET['motivo'] ?? '';

        Vistoria::cancel($id, $motivo);

        $this->redirect('/vistorias');
    }
}
