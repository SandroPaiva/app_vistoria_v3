<?php

namespace app\Models;

use app\Core\Model;

class ItemReparo extends Model {
    public static function all(): array {
        $db = self::getDb();
        $query = "SELECT * FROM itens_reparo ORDER BY tipo_reparo, classificacao_vidro";
        return $db->query($query)->fetchAll();
    }

    public static function allActive(): array {
        $db = self::getDb();
        $query = "SELECT * FROM itens_reparo WHERE ativo = 1 ORDER BY tipo_reparo, classificacao_vidro";
        return $db->query($query)->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM itens_reparo WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch();
        return $item ?: null;
    }

    public static function create(array $data): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO itens_reparo (tipo_reparo, classificacao_vidro, especificacao_outros, ativo) 
            VALUES (:tipo, :classificacao, :especificacao, :ativo)
        ");
        return $stmt->execute([
            ':tipo' => $data['tipo_reparo'],
            ':classificacao' => $data['classificacao_vidro'],
            ':especificacao' => $data['especificacao_outros'] ?? null,
            ':ativo' => isset($data['ativo']) ? (int)$data['ativo'] : 1
        ]);
    }

    public static function update(int $id, array $data): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            UPDATE itens_reparo 
            SET tipo_reparo = :tipo, classificacao_vidro = :classificacao, 
                especificacao_outros = :especificacao, ativo = :ativo
            WHERE id = :id
        ");
        return $stmt->execute([
            ':tipo' => $data['tipo_reparo'],
            ':classificacao' => $data['classificacao_vidro'],
            ':especificacao' => $data['especificacao_outros'] ?? null,
            ':ativo' => isset($data['ativo']) ? (int)$data['ativo'] : 1,
            ':id' => $id
        ]);
    }

    public static function deactivate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE itens_reparo SET ativo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function activate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE itens_reparo SET ativo = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
