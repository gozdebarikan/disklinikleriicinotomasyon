<?php


namespace App\Database;

use PDO;
use PDOException;
use Exception;

class Connection {
    private static $instance = null;
    private $pdo;
    private $config;
    
    
    private function __construct(array $config) {
        $this->config = $config;
        $this->connect();
    }
    
    
    private function connect(): void {
        try {
            $driver = $this->config['driver'] ?? 'sqlite';
            
            switch ($driver) {
                case 'sqlite':
                    $this->connectSQLite();
                    break;
                    
                case 'pgsql':
                    $this->connectPostgreSQL();
                    break;
                    
                default:
                    throw new Exception("Unsupported database driver: {$driver}");
            }
            
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Unable to connect to database. Please try again later.");
        }
    }
    
    
    private function connectSQLite(): void {
        $dbPath = $this->config['database_path'];
        $dbFolder = dirname($dbPath);
        
        
        if (!is_dir($dbFolder)) {
            mkdir($dbFolder, 0777, true);
        }
        
        
        if (!file_exists($dbPath)) {
            touch($dbPath);
        }
        
        $dsn = "sqlite:{$dbPath}";
        $this->pdo = new PDO($dsn, null, null);
    }
    
    
    private function connectPostgreSQL(): void {
        $dsn = sprintf(
            "pgsql:host=%s;port=%s;dbname=%s",
            $this->config['host'] ?? 'localhost',
            $this->config['port'] ?? '5432',
            $this->config['database'] ?? 'dental_app'
        );
        
        $username = $this->config['username'] ?? 'postgres';
        $password = $this->config['password'] ?? '';
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $this->pdo = new PDO($dsn, $username, $password, $options);
        
        
        if (!empty($this->config['schema'])) {
            $this->pdo->exec("SET search_path TO {$this->config['schema']}");
        }
    }
    
    
    public static function getInstance(array $config = null): PDO {
        if (self::$instance === null) {
            if ($config === null) {
                $config = require __DIR__ . '/../../config/database.php';
            }
            self::$instance = new self($config);
        }
        return self::$instance->pdo;
    }
    
    
    public function getDriver(): string {
        return $this->config['driver'] ?? 'sqlite';
    }
    
    
    public static function beginTransaction(): void {
        $pdo = self::getInstance();
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
    }
    
    
    public static function commit(): void {
        $pdo = self::getInstance();
        if ($pdo->inTransaction()) {
            $pdo->commit();
        }
    }
    
    
    public static function rollback(): void {
        $pdo = self::getInstance();
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
    }
    
    
    private function __clone() {}
    
    
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}