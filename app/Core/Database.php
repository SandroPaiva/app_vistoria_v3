<?php

namespace app\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $config = require BASE_PATH . '/config/database.php';
        
        try {
            $this->conn = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                $config['user'],
                $config['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Auto-migrations
            try {
                // vistorias: motivo_cancelamento
                $q = $this->conn->query("SHOW COLUMNS FROM vistorias LIKE 'motivo_cancelamento'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE vistorias ADD COLUMN motivo_cancelamento TEXT AFTER assinatura_digital");
                }

                // vistorias: data_agendamento
                $q = $this->conn->query("SHOW COLUMNS FROM vistorias LIKE 'data_agendamento'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE vistorias ADD COLUMN data_agendamento DATETIME NULL AFTER tecnico_id");
                }

                // vistorias: motivo_servico
                $q = $this->conn->query("SHOW COLUMNS FROM vistorias LIKE 'motivo_servico'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE vistorias ADD COLUMN motivo_servico VARCHAR(50) DEFAULT 'Primeiro Serviço' AFTER status");
                }

                // vistorias: observacao_motivo
                $q = $this->conn->query("SHOW COLUMNS FROM vistorias LIKE 'observacao_motivo'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE vistorias ADD COLUMN observacao_motivo TEXT NULL AFTER motivo_servico");
                }

                // vistorias: status ENUM update to include 'Agendado'
                $this->conn->exec("ALTER TABLE vistorias MODIFY COLUMN status ENUM('Agendado', 'Em Andamento', 'Concluído', 'Cancelado') DEFAULT 'Em Andamento'");

                // veiculos: data_agendamento
                $q = $this->conn->query("SHOW COLUMNS FROM veiculos LIKE 'data_agendamento'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE veiculos ADD COLUMN data_agendamento DATETIME NULL AFTER item_reparo_id");
                }

                // veiculos: tecnico_agendado_id
                $q = $this->conn->query("SHOW COLUMNS FROM veiculos LIKE 'tecnico_agendado_id'");
                if ($q->rowCount() === 0) {
                    $this->conn->exec("ALTER TABLE veiculos ADD COLUMN tecnico_agendado_id INT NULL AFTER data_agendamento");
                }
            } catch (PDOException $ex) {
                // Ignore migration errors during runtime
            }
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
