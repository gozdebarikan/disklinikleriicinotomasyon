<?php


namespace App\Controllers\Api\V1;

use App\Services\AuthService;
use App\Utils\JwtHandler;
use App\Utils\ApiResponse;
use App\Utils\Logger;
use App\Middleware\RateLimitMiddleware;
use App\Middleware\JwtMiddleware;
use App\Repositories\UserRepository;

class AuthApiController {
    private $authService;
    
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    
    public function login() {
        
        RateLimitMiddleware::check('login');
        
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            ApiResponse::error('Invalid JSON', 400);
        }
        
        
        if (empty($input['email']) || empty($input['password'])) {
            ApiResponse::validationError([
                'email' => 'Email is required',
                'password' => 'Password is required'
            ]);
        }
        
        try {
            
            $user = $this->authService->login($input['email'], $input['password']);
            
            
            $token = JwtHandler::createToken([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ]);
            
            
            Logger::logAction('API login successful', [
                'user_id' => $user['id'],
                'email' => $user['email']
            ]);
            
            
            ApiResponse::success([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 86400, 
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'role' => $user['role']
                ]
            ], 'Login successful');
            
        } catch (\Exception $e) {
            Logger::warning('API login failed', [
                'email' => $input['email'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            
            ApiResponse::unauthorized($e->getMessage());
        }
    }
    
    
    public function register() {
        
        RateLimitMiddleware::check('api');
        
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            ApiResponse::error('Invalid JSON', 400);
        }
        
        try {
            
            $user = $this->authService->register($input);
            
            
            $token = JwtHandler::createToken([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ]);
            
            
            Logger::logAction('API registration successful', [
                'user_id' => $user['id'],
                'email' => $user['email']
            ]);
            
            
            ApiResponse::created([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 86400,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'role' => $user['role']
                ]
            ], 'Registration successful');
            
        } catch (\Exception $e) {
            Logger::warning('API registration failed', [
                'email' => $input['email'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            
            ApiResponse::error($e->getMessage(), 400);
        }
    }
    
    
    public function refresh() {
        $token = JwtHandler::getTokenFromHeader();
        
        if (!$token) {
            ApiResponse::unauthorized('No token provided');
        }
        
        $newToken = JwtHandler::refreshToken($token);
        
        if (!$newToken) {
            ApiResponse::unauthorized('Invalid or expired token');
        }
        
        ApiResponse::success([
            'token' => $newToken,
            'token_type' => 'Bearer',
            'expires_in' => 86400
        ], 'Token refreshed');
    }
    
    
    public function me() {
        $payload = JwtMiddleware::require();
        
        
        global $db;
        $userRepo = new UserRepository($db);
        $user = $userRepo->findById($payload['user_id']);
        
        if (!$user) {
            ApiResponse::notFound('User not found');
        }
        
        ApiResponse::success([
            'id' => $user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'tc_no' => $user['tc_no'],
            'role' => $user['role'],
            'created_at' => $user['created_at']
        ]);
    }
}
