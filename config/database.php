<?php

return [
    'host' => getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost'),
    'dbname' => getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'pilkington_vistoria'),
    'user' => getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'sandropaiva'),
    'password' => getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? 'Sandro@123'),
    'charset' => getenv('DB_CHARSET') ?: ($_ENV['DB_CHARSET'] ?? 'utf8mb4')
];
