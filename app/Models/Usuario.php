<?php

namespace app\Models;

use app\Core\Model;
use PDO;

class Usuario extends Model {
    public static function findByLogin(string $login): ?array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE login = :login LIMIT 1");
        $stmt->bindValue(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findById(int $id, bool $onlyActive = false): ?array {
        $db = self::getDb();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        if ($onlyActive) {
            $sql .= " AND ativo = 1";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function all(?string $userProfile = null): array {
        $db = self::getDb();
        if ($userProfile === 'Gerente') {
            $query = "SELECT * FROM usuarios WHERE perfil_acesso IN ('Supervisor', 'Técnico') ORDER BY nome_completo";
        } else {
            $query = "SELECT * FROM usuarios ORDER BY nome_completo";
        }
        return $db->query($query)->fetchAll();
    }

    public static function allActive(?string $userProfile = null): array {
        $db = self::getDb();
        if ($userProfile === 'Gerente') {
            $query = "SELECT * FROM usuarios WHERE ativo = 1 AND perfil_acesso IN ('Supervisor', 'Técnico') ORDER BY nome_completo";
        } else {
            $query = "SELECT * FROM usuarios WHERE ativo = 1 ORDER BY nome_completo";
        }
        return $db->query($query)->fetchAll();
    }

    public static function getActiveTecnicos(?int $specificId = null): array {
        $db = self::getDb();
        if ($specificId !== null) {
            $stmt = $db->prepare("SELECT id, nome_completo FROM usuarios WHERE id = :id AND ativo = 1");
            $stmt->execute([':id' => $specificId]);
            return $stmt->fetchAll();
        }

        return $db->query("SELECT id, nome_completo FROM usuarios WHERE ativo = 1 AND perfil_acesso = 'Técnico' ORDER BY nome_completo")->fetchAll();
    }

    public static function create(array $data): bool {
        $db = self::getDb();
        $stmt = $db->prepare("
            INSERT INTO usuarios (nome_completo, email, login, senha_hash, perfil_acesso, ativo) 
            VALUES (:nome, :email, :login, :senha, :perfil, :ativo)
        ");
        return $stmt->execute([
            ':nome' => $data['nome_completo'],
            ':email' => $data['email'],
            ':login' => $data['login'],
            ':senha' => $data['senha_hash'],
            ':perfil' => $data['perfil_acesso'],
            ':ativo' => isset($data['ativo']) ? (int)$data['ativo'] : 1
        ]);
    }

    public static function update(int $id, array $data): bool {
        $db = self::getDb();
        $hasPassword = !empty($data['senha_hash']);
        $hasAtivo = isset($data['ativo']);

        $fields = [
            'nome_completo = :nome',
            'email = :email',
            'login = :login',
            'perfil_acesso = :perfil'
        ];
        $params = [
            ':nome' => $data['nome_completo'],
            ':email' => $data['email'],
            ':login' => $data['login'],
            ':perfil' => $data['perfil_acesso'],
            ':id' => $id
        ];

        if ($hasPassword) {
            $fields[] = 'senha_hash = :senha';
            $params[':senha'] = $data['senha_hash'];
        }

        if ($hasAtivo) {
            $fields[] = 'ativo = :ativo';
            $params[':ativo'] = (int)$data['ativo'];
        }

        $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function deactivate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE usuarios SET ativo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function activate(int $id): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE usuarios SET ativo = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function updateName(int $id, string $newName): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE usuarios SET nome_completo = :nome, data_alteracao = NOW() WHERE id = :id");
        return $stmt->execute([':nome' => $newName, ':id' => $id]);
    }

    public static function updatePassword(int $id, string $newPasswordHash): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE usuarios SET senha_hash = :senha, data_alteracao = NOW() WHERE id = :id");
        return $stmt->execute([':senha' => $newPasswordHash, ':id' => $id]);
    }
}
