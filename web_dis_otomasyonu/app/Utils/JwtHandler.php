<?php


namespace App\Utils;

class JwtHandler {
    private static $secretKey;
    private static $algorithm = 'HS256';
    private static $tokenExpiry = 86400; 
    
    
    public static function init(): void {
        
        self::$secretKey = getenv('APP_KEY') ?: self::generateSecretKey();
        
        if (strlen(self::$secretKey) < 32) {
            throw new \Exception('JWT secret key must be at least 32 characters');
        }
    }
    
    
    private static function generateSecretKey(): string {
        return bin2hex(random_bytes(32));
    }
    
    
    public static function createToken(array $payload): string {
        self::init();
        
        
        $header = [
            'typ' => 'JWT',
            'alg' => self::$algorithm
        ];
        
        
        $payload['iat'] = time(); 
        $payload['exp'] = time() + self::$tokenExpiry; 
        $payload['iss'] = $_SERVER['HTTP_HOST'] ?? 'dental-app'; 
        
        
        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        
        
        $signature = hash_hmac(
            'sha256',
            $headerEncoded . '.' . $payloadEncoded,
            self::$secretKey,
            true
        );
        $signatureEncoded = self::base64UrlEncode($signature);
        
        
        return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
    }
    
    
    public static function verifyToken(string $token): ?array {
        self::init();
        
        
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return null;
        }
        
        [$headerEncoded, $payloadEncoded, $signatureEncoded] = $parts;
        
        
        $signature = hash_hmac(
            'sha256',
            $headerEncoded . '.' . $payloadEncoded,
            self::$secretKey,
            true
        );
        
        $expectedSignature = self::base64UrlEncode($signature);
        
        if (!hash_equals($expectedSignature, $signatureEncoded)) {
            return null; 
        }
        
        
        $payload = json_decode(self::base64UrlDecode($payloadEncoded), true);
        
        if (!$payload) {
            return null;
        }
        
        
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null; 
        }
        
        return $payload;
    }
    
    
    public static function getTokenFromHeader(): ?string {
        $headers = getallheaders();
        
        if (isset($headers['Authorization'])) {
            
            if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }
    
    
    public static function refreshToken(string $token): ?string {
        $payload = self::verifyToken($token);
        
        if (!$payload) {
            return null;
        }
        
        
        unset($payload['iat'], $payload['exp'], $payload['iss']);
        
        
        return self::createToken($payload);
    }
    
    
    private static function base64UrlEncode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    
    private static function base64UrlDecode(string $data): string {
        return base64_decode(strtr($data, '-_', '+/'));
    }
    
    
    public static function setExpiry(int $seconds): void {
        self::$tokenExpiry = $seconds;
    }
}
