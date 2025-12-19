<?php


namespace App\Middleware;

class RateLimitMiddleware {
    private static $limits = [
        'api' => ['requests' => 100, 'window' => 3600], 
        'login' => ['requests' => 5, 'window' => 900],  
        'default' => ['requests' => 60, 'window' => 60], 
    ];
    
    
    public static function check(string $type = 'default', string $identifier = null): bool {
        $limit = self::$limits[$type] ?? self::$limits['default'];
        
        
        if ($identifier === null) {
            $identifier = self::getClientIp();
        }
        
        $key = "rate_limit:{$type}:{$identifier}";
        
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data = $_SESSION[$key] ?? null;
        
        
        if ($data && isset($data['expires']) && $data['expires'] > time()) {
            
            $_SESSION[$key]['count']++;
            
            
            if ($_SESSION[$key]['count'] > $limit['requests']) {
                http_response_code(429);
                $retryAfter = $data['expires'] - time();
                header("Retry-After: {$retryAfter}");
                die(json_encode([
                    'error' => 'Too many requests',
                    'retry_after' => $retryAfter
                ]));
            }
        } else {
            
            $_SESSION[$key] = [
                'count' => 1,
                'expires' => time() + $limit['window']
            ];
        }
        
        return true;
    }
    
    
    public static function getRemaining(string $type = 'default', string $identifier = null): int {
        $limit = self::$limits[$type] ?? self::$limits['default'];
        
        if ($identifier === null) {
            $identifier = self::getClientIp();
        }
        
        $key = "rate_limit:{$type}:{$identifier}";
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data = $_SESSION[$key] ?? null;
        
        if (!$data || !isset($data['count'])) {
            return $limit['requests'];
        }
        
        return max(0, $limit['requests'] - $data['count']);
    }
    
    
    public static function reset(string $type = 'default', string $identifier = null): void {
        if ($identifier === null) {
            $identifier = self::getClientIp();
        }
        
        $key = "rate_limit:{$type}:{$identifier}";
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION[$key]);
    }
    
    
    private static function getClientIp(): string {
        $ipKeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
