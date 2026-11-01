<?php

namespace app\Models;

use app\Core\Model;

class Veiculo extends Model {
    public static function all(): array {
        $db = self::getDb();
        $query = "SELECT * FROM veiculos ORDER BY data_criacao DESC";
        return $db->query($query)->fetchAll();
    }

    public static function allActive(): array {
        $db = self::getDb();
        $query = "SELECT * FROM veiculos WHERE ativo = 1 ORDER BY data_criacao DESC";
        return $db->query($query)->fetchAll();
    }

    public static function allActiveSimple(): array {
        $db = self::getDb();
        $query = "SELECT id, placa, fabricante, modelo FROM veiculos WHERE ativo = 1 ORDER BY placa";
        return $db->query($query)->fetchAll();
    }

    /**
     * Retorna apenas veículos ativos que NÃO possuem nenhum serviço registrado em vistorias
     */
    public static function availableForNewService(): array {
        $db = self::getDb();
        $query = "
            SELECT v.id, v.placa, v.fabricante, v.modelo 
            FROM veiculos v 
            WHERE v.ativo = 1 
              AND NOT EXISTS (
                  SELECT 1 FROM vistorias vis WHERE vis.veiculo_id = v.id
              )
            ORDER BY v.placa
        ";
        return $db->query($query)->fetchAll();
    }

    public static function allWithItem(): array {
        $db = self::getDb();
        $query = "
            SELECT v.*, ir.tipo_reparo, ir.classificacao_vidro,
                   (SELECT COUNT(*) FROM vistorias vis WHERE vis.veiculo_id = v.id) as total_servicos,
                   u.nome_completo as nome_tecnico_agendado
            FROM veiculos v 
            LEFT JOIN itens_reparo ir ON v.item_reparo_id = ir.id 
            LEFT JOIN usuarios u ON v.tecnico_agendado_id = u.id
            ORDER BY v.data_criacao DESC
        ";
        return $db->query($query)->fetchAll();
    }

    public static function allActiveWithItem(): array {
        $db = self::getDb();
        $query = "
            SELECT v.*, ir.tipo_reparo, ir.classificacao_vidro,
                   (SELECT COUNT(*) FROM vistorias vis WHERE vis.veiculo_id = v.id) as total_servicos,
                   u.nome_completo as nome_tecnico_agendado
            FROM veiculos v 
            LEFT JOIN itens_reparo ir ON v.item_reparo_id = ir.id 
            LEFT JOIN usuarios u ON v.tecnico_agendado_id = u.id
            WHERE v.ativo = 1 
            ORDER BY v.data_criacao DESC
        ";
        return $db->query($query)->fetchAll();
    }

    public static function hasServices(int $veiculoId): bool {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT COUNT(*) FROM vistorias WHERE veiculo_id = :id");
        $stmt->execute([':id' => $veiculoId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public static function findById(int $id): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM veiculos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $veiculo = $stmt->fetch();
        return $veiculo ?: null;
    }

    public static function findByIdWithItem(int $id): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT v.*, ir.tipo_reparo, ir.classificacao_vidro,
                   u.nome_completo as nome_tecnico_agendado
            FROM veiculos v 
            LEFT JOIN itens_reparo ir ON v.item_reparo_id = ir.id 
            LEFT JOIN usuarios u ON v.tecnico_agendado_id = u.id
            WHERE v.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $veiculo = $stmt->fetch();
        return $veiculo ?: null;
    }

    public static function create(array $data): int {
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO veiculos (
                placa, chassi, fabricante, modelo, ano_fabricacao, tipo_veiculo, 
                nome_proprietario, telefone_proprietario, item_reparo_id, 
                data_agendamento, tecnico_agendado_id, ativo
            ) 
            VALUES (
                :placa, :chassi, :fabricante, :modelo, :ano, :tipo, 
                :proprietario, :telefone, :item_id, 
                :data_agendamento, :tecnico_agendado_id, :ativo
            )
        ");
        $stmt->execute([
            ':placa' => $data['placa'],
            ':chassi' => $data['chassi'] ?? null,
            ':fabricante' => $data['fabricante'] ?? null,
            ':modelo' => $data['modelo'] ?? null,
            ':ano' => $data['ano_fabricacao'] ?? null,
            ':tipo' => $data['tipo_veiculo'],
            ':proprietario' => $data['nome_proprietario'] ?? null,
            ':telefone' => $data['telefone_proprietario'] ?? null,
            ':item_id' => !empty($data['item_reparo_id']) ? $data['item_reparo_id'] : null,
            ':data_agendamento' => !empty($data['data_agendamento']) ? $data['data_agendamento'] : null,
            ':tecnico_agendado_id' => !empty($data['tecnico_agendado_id']) ? $data['tecnico_agendado_id'] : null,
            ':ativo' => isset($data['ativo']) ? (int)$data['ativo'] : 1
        ]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            UPDATE veiculos 
            SET placa = :placa, chassi = :chassi, fabricante = :fabricante, modelo = :modelo, 
                ano_fabricacao = :ano, tipo_veiculo = :tipo, nome_proprietario = :proprietario, 
                telefone_proprietario = :telefone, item_reparo_id = :item_id,
                data_agendamento = :data_agendamento, tecnico_agendado_id = :tecnico_agendado_id,
                ativo = :ativo
            WHERE id = :id
        ");
        return $stmt->execute([
            ':placa' => $data['placa'],
            ':chassi' => $data['chassi'] ?? null,
            ':fabricante' => $data['fabricante'] ?? null,
            ':modelo' => $data['modelo'] ?? null,
            ':ano' => $data['ano_fabricacao'] ?? null,
            ':tipo' => $data['tipo_veiculo'],
            ':proprietario' => $data['nome_proprietario'] ?? null,
            ':telefone' => $data['telefone_proprietario'] ?? null,
            ':item_id' => !empty($data['item_reparo_id']) ? $data['item_reparo_id'] : null,
            ':data_agendamento' => !empty($data['data_agendamento']) ? $data['data_agendamento'] : null,
            ':tecnico_agendado_id' => !empty($data['tecnico_agendado_id']) ? $data['tecnico_agendado_id'] : null,
            ':ativo' => isset($data['ativo']) ? (int)$data['ativo'] : 1,
            ':id' => $id
        ]);
    }

    public static function deactivate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE veiculos SET ativo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function activate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE veiculos SET ativo = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
