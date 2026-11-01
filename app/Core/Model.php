<?php

namespace app\Core;

use PDO;

abstract class Model {
    protected static function getDb(): PDO {
        return Database::getInstance()->getConnection();
    }
}
