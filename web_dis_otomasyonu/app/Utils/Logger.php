<?php


namespace App\Utils;

class Logger {
    private static $logPath = null;
    private static $levels = ['DEBUG', 'INFO', 'WARNING', 'ERROR', 'CRITICAL'];
    
    
    public static function init(): void {
        if (self::$logPath === null) {
            $logDir = __DIR__ . '/../../storage/logs';
            
            
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            
            self::$logPath = $logDir . '/' . date('Y-m-d') . '.log';
        }
    }
    
    
    private static function log(string $level, string $message, array $context = []): void {
        self::init();
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        
        $logMessage = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
        
        file_put_contents(self::$logPath, $logMessage, FILE_APPEND | LOCK_EX);
    }
    
    
    public static function debug(string $message, array $context = []): void {
        self::log('DEBUG', $message, $context);
    }
    
    
    public static function info(string $message, array $context = []): void {
        self::log('INFO', $message, $context);
    }
    
    
    public static function warning(string $message, array $context = []): void {
        self::log('WARNING', $message, $context);
    }
    
    
    public static function error(string $message, array $context = []): void {
        self::log('ERROR', $message, $context);
    }
    
    
    public static function critical(string $message, array $context = []): void {
        self::log('CRITICAL', $message, $context);
    }
    
    
    public static function logRequest(): void {
        $data = [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
            'uri' => $_SERVER['REQUEST_URI'] ?? 'UNKNOWN',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN',
        ];
        
        self::info('HTTP Request', $data);
    }
    
    
    public static function logAction(string $action, array $data = []): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user_id'] ?? 'guest';
        
        self::info("User Action: {$action}", array_merge(['user_id' => $userId], $data));
    }
}
