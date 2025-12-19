<?php


namespace App\Middleware;

class AuthMiddleware {
    
    public static function check(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    
    public static function require(string $redirectTo = null): void {
        if (!self::check()) {
            $target = $redirectTo ?? url('/login');
            header("Location: {$target}");
            exit;
        }
    }
    
    
    public static function userId(): ?int {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['user_id'] ?? null;
    }
    
    
    public static function user(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!self::check()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? 'patient',
        ];
    }
    
    
    public static function hasRole(string $role): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userRole = $_SESSION['user_role'] ?? 'patient';
        return $userRole === $role;
    }
    
    
    public static function requireRole(string $role, string $redirectTo = '/'): void {
        if (!self::hasRole($role)) {
            http_response_code(403);
            header("Location: {$redirectTo}");
            exit;
        }
    }
    
    
    public static function login(array $userData): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_role'] = $userData['role'] ?? 'patient';
        $_SESSION['login_time'] = time();
    }
    
    
    public static function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        
        session_start();
        session_regenerate_id(true);
    }
    
    
    public static function isExpired(int $maxLifetime = 7200): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['login_time'])) {
            return true;
        }
        
        return (time() - $_SESSION['login_time']) > $maxLifetime;
    }
}
