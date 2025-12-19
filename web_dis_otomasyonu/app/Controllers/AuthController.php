<?php


namespace App\Controllers;

use App\Services\AuthService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Utils\Logger;

class AuthController {
    private $authService;
    
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    public function login() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrfToken = CsrfMiddleware::getToken();
            require __DIR__ . '/../../resources/views/auth/login.php';
            return;
        }
        
        
        try {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                throw new \Exception('Email ve şifre gerekli');
            }
            
            $user = $this->authService->login($_POST['email'], $_POST['password']);
            
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'] ?? 'patient';
            
            header('Location: ' . url('/'));
            exit;
            
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $csrfToken = CsrfMiddleware::getToken();
            require __DIR__ . '/../../resources/views/auth/login.php';
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrfToken = CsrfMiddleware::getToken();
            require __DIR__ . '/../../resources/views/auth/register.php';
            return;
        }
        
        try {
            $user = $this->authService->register($_POST);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'] ?? 'patient';
            header('Location: ' . url('/'));
            exit;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $csrfToken = CsrfMiddleware::getToken();
            require __DIR__ . '/../../resources/views/auth/register.php';
        }
    }
    
    public function profile() {
        $userId = $_SESSION['user_id'] ?? 0;
        $success = null;
        $error = null;
        
        
        try {
            $user = $this->authService->getUserById($userId);
        } catch (\Exception $e) {
            
            $user = [
                'id' => $userId,
                'first_name' => explode(' ', $_SESSION['user_name'] ?? 'User')[0],
                'last_name' => explode(' ', $_SESSION['user_name'] ?? 'User')[1] ?? '',
                'email' => $_SESSION['user_email'] ?? ''
            ];
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->authService->updateProfile($userId, $_POST);
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $success = true;
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        return [
            'user' => $user,
            'success' => $success,
            'error' => $error,
            'csrfToken' => CsrfMiddleware::getToken()
        ];
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . url('/login'));
        exit;
    }
}