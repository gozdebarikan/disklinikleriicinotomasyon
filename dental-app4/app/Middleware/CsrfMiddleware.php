<?php


namespace App\Middleware;

class CsrfMiddleware {
    
    public static function generateToken(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
    
    
    public static function validate(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return true;
        }
        
        
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        
        
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        
        if (!hash_equals($sessionToken, $token)) {
            http_response_code(403);
            die(json_encode(['error' => '

 token validation failed']));
        }
        
        return true;
    }
    
    
    public static function getTokenInput(): string {
        $token = self::generateToken();
        return "<input type='hidden' name='csrf_token' value='{$token}'>";
    }
    
    
    public static function getTokenMeta(): string {
        $token = self::generateToken();
        return "<meta name='csrf-token' content='{$token}'>";
    }
    
    
    public static function getToken(): string {
        return self::generateToken();
    }
}
