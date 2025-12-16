<?php


namespace App\Services;

use App\Repositories\UserRepository;

class AuthService {
    private $userRepo;
    
    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }
    
    
    public function getUserById(int|string $userId): ?array {
        $user = $this->userRepo->findById($userId);
        return $user ? $this->sanitizeUser($user) : null;
    }
    
    
    public function login(string $email, string $password): array {
        
        if (empty($email) || empty($password)) {
            throw new \Exception('Email and password are required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email format');
        }
        
        
        $user = $this->userRepo->verifyPassword($email, $password);
        
        if (!$user) {
            
            throw new \Exception('Invalid credentials');
        }
        
        
        return $this->sanitizeUser($user);
    }
    
    
    public function register(array $data): array {
        
        $required = ['tc_no', 'first_name', 'last_name', 'email', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new \Exception("Field '{$field}' is required");
            }
        }
        
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email format');
        }
        
        
        if (!preg_match('/^\d{11}$/', $data['tc_no'])) {
            throw new \Exception('TC number must be 11 digits');
        }
        
        
        if (strlen($data['password']) < 6) {
            throw new \Exception('Password must be at least 6 characters');
        }
        
        
        try {
            $userId = $this->userRepo->createUser($data);
            $user = $this->userRepo->findById($userId);
            
            return $this->sanitizeUser($user);
            
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    
    public function updateProfile(int|string $userId, array $data): array {
        
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email format');
        }
        
        
        if (isset($data['password']) && !empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                throw new \Exception('Password must be at least 6 characters');
            }
        }
        
        
        $this->userRepo->updateProfile($userId, $data);
        
        
        $user = $this->userRepo->findById($userId);
        return $this->sanitizeUser($user);
    }
    
    
    public function changePassword(int|string $userId, string $currentPassword, string $newPassword): bool {
        
        $user = $this->userRepo->findById($userId);
        
        if (!$user) {
            throw new \Exception('User not found');
        }
        
        
        if (!password_verify($currentPassword, $user['password_hash'])) {
            throw new \Exception('Current password is incorrect');
        }
        
        
        if (strlen($newPassword) < 6) {
            throw new \Exception('New password must be at least 6 characters');
        }
        
        
        return $this->userRepo->updateProfile($userId, ['password' => $newPassword]);
    }
    
    
    public function createSession(array $user): array {
        return [
            'user_id' => $user['id'],
            'user_name' => $user['first_name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'session_token' => bin2hex(random_bytes(32))
        ];
    }
    
    
    private function sanitizeUser(array $user): array {
        unset($user['password_hash']);
        return $user;
    }
    
    
    public function verifySession(string $token): bool {
        
        
        return !empty($token);
    }
}
