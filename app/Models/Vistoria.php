<?php

namespace app\Models;

use app\Core\Model;
use PDO;

class Vistoria extends Model {
    public static function allWithDetails(?int $tecnicoId = null): array {
        $db = self::getDb();
        if ($tecnicoId !== null) {
            $query = "
                SELECT v.*, ve.placa, ve.fabricante, ve.modelo, ve.nome_proprietario, ve.telefone_proprietario,
                       u.nome_completo as nome_tecnico, ir.tipo_reparo, ir.classificacao_vidro
                FROM vistorias v 
                JOIN veiculos ve ON v.veiculo_id = ve.id
                JOIN usuarios u ON v.tecnico_id = u.id
                LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
                WHERE v.tecnico_id = :tecnico_id
                ORDER BY COALESCE(v.data_agendamento, v.data_inicio, v.data_criacao) DESC
            ";
            $stmt = $db->prepare($query);
            $stmt->execute([':tecnico_id' => $tecnicoId]);
            return $stmt->fetchAll();
        }

        $query = "
            SELECT v.*, ve.placa, ve.fabricante, ve.modelo, ve.nome_proprietario, ve.telefone_proprietario,
                   u.nome_completo as nome_tecnico, ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v 
            JOIN veiculos ve ON v.veiculo_id = ve.id
            JOIN usuarios u ON v.tecnico_id = u.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            ORDER BY COALESCE(v.data_agendamento, v.data_inicio, v.data_criacao) DESC
        ";
        return $db->query($query)->fetchAll();
    }

    public static function byStatusWithDetails(string $status, ?int $tecnicoId = null): array {
        $db = self::getDb();
        if ($tecnicoId !== null) {
            $stmt = $db->prepare("
                SELECT v.*, ve.placa, ve.fabricante, ve.modelo, ve.nome_proprietario, ve.telefone_proprietario,
                       u.nome_completo as nome_tecnico, ir.tipo_reparo, ir.classificacao_vidro
                FROM vistorias v 
                JOIN veiculos ve ON v.veiculo_id = ve.id 
                JOIN usuarios u ON v.tecnico_id = u.id
                LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
                WHERE v.status = :status AND v.tecnico_id = :tecnico_id
                ORDER BY v.data_criacao DESC
            ");
            $stmt->execute([':status' => $status, ':tecnico_id' => $tecnicoId]);
            return $stmt->fetchAll();
        }

        $stmt = $db->prepare("
            SELECT v.*, ve.placa, ve.fabricante, ve.modelo, ve.nome_proprietario, ve.telefone_proprietario,
                       u.nome_completo as nome_tecnico, ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v 
            JOIN veiculos ve ON v.veiculo_id = ve.id 
            JOIN usuarios u ON v.tecnico_id = u.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE v.status = :status
            ORDER BY v.data_criacao DESC
        ");
        $stmt->execute([':status' => $status]);
        return $stmt->fetchAll();
    }

    public static function getScheduledForDate(string $date, ?int $tecnicoId = null): array {
        $db = self::getDb();
        $sql = "
            SELECT v.*, ve.placa, ve.fabricante, ve.modelo, ve.nome_proprietario, ve.telefone_proprietario,
                   u.nome_completo as nome_tecnico, ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v 
            JOIN veiculos ve ON v.veiculo_id = ve.id 
            JOIN usuarios u ON v.tecnico_id = u.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE DATE(COALESCE(v.data_agendamento, v.data_inicio)) = :targetDate
              AND v.status IN ('Agendado', 'Em Andamento')
        ";
        $params = [':targetDate' => $date];

        if ($tecnicoId !== null) {
            $sql .= " AND v.tecnico_id = :tecnicoId";
            $params[':tecnicoId'] = $tecnicoId;
        }

        $sql .= " ORDER BY COALESCE(v.data_agendamento, v.data_inicio) ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getScheduledAllForMonth(int $year, int $month, ?int $tecnicoId = null): array {
        $db = self::getDb();
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $sql = "
            SELECT v.id, v.veiculo_id, v.tecnico_id, v.status, v.data_agendamento, v.motivo_servico,
                   DATE(COALESCE(v.data_agendamento, v.data_inicio)) as data_dia,
                   ve.placa, ve.fabricante, ve.modelo,
                   u.nome_completo as nome_tecnico,
                   ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v
            JOIN veiculos ve ON v.veiculo_id = ve.id
            JOIN usuarios u ON v.tecnico_id = u.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE DATE(COALESCE(v.data_agendamento, v.data_inicio)) BETWEEN :start AND :end
        ";
        $params = [
            ':start' => $startDate,
            ':end' => $endDate
        ];

        if ($tecnicoId !== null) {
            $sql .= " AND v.tecnico_id = :tecnicoId";
            $params[':tecnicoId'] = $tecnicoId;
        }

        $sql .= " ORDER BY COALESCE(v.data_agendamento, v.data_inicio) ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getHistoryByVeiculoId(int $veiculoId): array {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT v.*, u.nome_completo as nome_tecnico,
                   ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v
            JOIN usuarios u ON v.tecnico_id = u.id
            JOIN veiculos ve ON v.veiculo_id = ve.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE v.veiculo_id = :id
            ORDER BY COALESCE(v.data_agendamento, v.data_inicio, v.data_criacao) DESC
        ");
        $stmt->execute([':id' => $veiculoId]);
        return $stmt->fetchAll();
    }

    public static function getNextScheduledByVeiculoId(int $veiculoId): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT v.*, u.nome_completo as nome_tecnico,
                   ir.tipo_reparo, ir.classificacao_vidro
            FROM vistorias v
            JOIN usuarios u ON v.tecnico_id = u.id
            JOIN veiculos ve ON v.veiculo_id = ve.id
            LEFT JOIN itens_reparo ir ON ve.item_reparo_id = ir.id
            WHERE v.veiculo_id = :id AND v.status = 'Agendado'
            ORDER BY COALESCE(v.data_agendamento, v.data_inicio) ASC
            LIMIT 1
        ");
        $stmt->execute([':id' => $veiculoId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByIdWithDetails(int $id): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("
            SELECT v.*, ve.placa, ve.chassi, ve.fabricante, ve.modelo, ve.ano_fabricacao, 
                   ve.nome_proprietario, ve.telefone_proprietario,
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
        return $vistoria ?: null;
    }

    public static function findTecnicoId(int $id): ?int {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT tecnico_id FROM vistorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch();
        return $res ? (int)$res['tecnico_id'] : null;
    }

    public static function create(int $veiculoId, int $tecnicoId, ?string $dataAgendamento = null, string $status = 'Em Andamento', string $motivo = 'Primeiro Serviço', ?string $observacao = null): int {
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO vistorias (veiculo_id, tecnico_id, data_agendamento, status, motivo_servico, observacao_motivo) 
            VALUES (:veiculo_id, :tecnico_id, :data_agendamento, :status, :motivo, :observacao)
        ");
        $stmt->execute([
            ':veiculo_id' => $veiculoId,
            ':tecnico_id' => $tecnicoId,
            ':data_agendamento' => !empty($dataAgendamento) ? $dataAgendamento : null,
            ':status' => $status,
            ':motivo' => $motivo,
            ':observacao' => $observacao
        ]);
        return (int)$db->lastInsertId();
    }

    public static function startService(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            UPDATE vistorias 
            SET status = 'Em Andamento', data_inicio = CURRENT_TIMESTAMP 
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    public static function saveExecution(int $id, array $data): bool {
        $db = self::getDb();
        $status = $data['status'] ?? 'Em Andamento';
        $dataFimSql = ($status === 'Concluído') ? "CURRENT_TIMESTAMP" : "NULL";

        $stmt = $db->prepare("
            UPDATE vistorias 
            SET dados_reparo = :dados, 
                assinatura_digital = :assinatura, 
                status = :status,
                latitude = :lat, 
                longitude = :lng, 
                data_fim = $dataFimSql
            WHERE id = :id
        ");

        return $stmt->execute([
            ':dados' => $data['dados_reparo'] ?? '',
            ':assinatura' => $data['assinatura_digital'] ?? '',
            ':status' => $status,
            ':lat' => $data['latitude'] ?? null,
            ':lng' => $data['longitude'] ?? null,
            ':id' => $id
        ]);
    }

    public static function cancel(int $id, string $motivo): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            UPDATE vistorias 
            SET status = 'Cancelado', motivo_cancelamento = :motivo 
            WHERE id = :id
        ");
        return $stmt->execute([
            ':motivo' => $motivo,
            ':id' => $id
        ]);
    }
}
