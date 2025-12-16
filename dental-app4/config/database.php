<?php


return [
    
    'driver' => getenv('DB_CONNECTION') ?: 'sqlite',
    
    
    'database_path' => __DIR__ . '/../database/dental.sqlite',
    
    
    'host' => getenv('DB_HOST') ?: 'localhost',
    'port' => getenv('DB_PORT') ?: '5432',
    'database' => getenv('DB_NAME') ?: 'dental_app',
    'username' => getenv('DB_USER') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => 'utf8',
    'schema' => 'public',
    
    
    'options' => [
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_TIMEOUT => 5,
    ],
];