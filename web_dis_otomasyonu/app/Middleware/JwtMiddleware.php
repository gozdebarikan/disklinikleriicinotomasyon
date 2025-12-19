<?php


namespace App\Middleware;

use App\Utils\JwtHandler;
use App\Utils\ApiResponse;
use App\Utils\Logger;

class JwtMiddleware {
    
    public static function verify(): ?array {
        
        $token = JwtHandler::getTokenFromHeader();
        
        if (!$token) {
            ApiResponse::unauthorized('No token provided');
            return null;
        }
        
        
        $payload = JwtHandler::verifyToken($token);
        
        if (!$payload) {
            Logger::warning('Invalid JWT token attempt');
            ApiResponse::unauthorized('Invalid or expired token');
            return null;
        }
        
        return $payload;
    }
    
    
    public static function require(): array {
        $payload = self::verify();
        
        if (!$payload) {
            exit; 
        }
        
        return $payload;
    }
    
    
    public static function getUserId(): ?int {
        $payload = self::verify();
        
        if (!$payload || !isset($payload['user_id'])) {
            return null;
        }
        
        return (int)$payload['user_id'];
    }
    
    
    public static function hasRole(string $role): bool {
        $payload = self::verify();
        
        if (!$payload || !isset($payload['role'])) {
            return false;
        }
        
        return $payload['role'] === $role;
    }
    
    
    public static function optional(): ?array {
        $token = JwtHandler::getTokenFromHeader();
        
        if (!$token) {
            return null;
        }
        
        return JwtHandler::verifyToken($token);
    }
}
