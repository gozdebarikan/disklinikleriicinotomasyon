<?php


return [
    
    'driver' => getenv('DB_CONNECTION') ?: 'pgsql',
    
    
    'database_path' => __DIR__ . '/../database/dental.sqlite',
    
    
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '5432',
    'database' => getenv('DB_DATABASE') ?: 'dental_app',
    'username' => getenv('DB_USERNAME') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: 'admin123',
    'charset' => 'utf8',
    'schema' => 'public',
    
    
    'options' => [
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_TIMEOUT => 5,
    ],
];