<?php

namespace app\Models;

use app\Core\Model;

class FotoVistoria extends Model {
    public static function getByVistoriaId(int $vistoriaId): array {
        $db = self::getDb();
        $stmt = $db->prepare("SELECT * FROM fotos_vistoria WHERE vistoria_id = :id ORDER BY tipo_foto");
        $stmt->execute([':id' => $vistoriaId]);
        return $stmt->fetchAll();
    }

    public static function create(int $vistoriaId, string $tipoFoto, string $caminhoArquivo): bool {
        $db = self::getDb();
        $stmt = $db->prepare("INSERT INTO fotos_vistoria (vistoria_id, tipo_foto, caminho_arquivo) VALUES (?, ?, ?)");
        return $stmt->execute([$vistoriaId, $tipoFoto, $caminhoArquivo]);
    }
}
