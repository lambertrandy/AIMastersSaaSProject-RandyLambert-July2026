<?php
declare(strict_types=1);

return [
    'driver' => 'mysql',
    'host' => getenv('APP_DB_HOST') ?: 'db',
    'port' => (int) (getenv('APP_DB_PORT') ?: 3306),
    'database' => getenv('APP_DB_NAME') ?: 'ai_db',
    'username' => getenv('APP_DB_USER') ?: '',
    'password' => getenv('APP_DB_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
];
