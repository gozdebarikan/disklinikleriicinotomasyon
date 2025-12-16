<?php


namespace App\Repositories;

use PDO;

class UserRepository extends BaseRepository {
    protected $table = 'hastalar';  // Eski: 'users'
    
    
    public function findByEmail(string $email): ?array {
        return $this->findOneBy('email', $email);
    }
    
    
    public function findByTcNo(string $tcNo): ?array {
        return $this->findOneBy('tc_kimlik', $tcNo);  // Eski: 'tc_no'
    }
    
    
    public function createUser(array $data): int|string {
        
        if ($this->exists('email', $data['email'])) {
            throw new \Exception('Email already registered');
        }
        
        
        if (isset($data['tc_no']) && $this->exists('tc_kimlik', $data['tc_no'])) {
            throw new \Exception('TC number already registered');
        }
        
        // Kolon ismi mapping (eski → yeni)
        $mappedData = [
            'ad' => $data['first_name'] ?? $data['ad'] ?? '',
            'soyad' => $data['last_name'] ?? $data['soyad'] ?? '',
            'email' => $data['email'],
            'telefon' => $data['phone'] ?? $data['telefon'] ?? null,
            'tc_kimlik' => $data['tc_no'] ?? $data['tc_kimlik'] ?? null,
        ];
        
        // Şifre hashleme (BCrypt)
        if (isset($data['password'])) {
            $mappedData['sifre_hash'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }
        
        return $this->create($mappedData);
    }
    
    
    public function updateProfile(int|string $id, array $data): bool {
        
        unset($data['id'], $data['created_at'], $data['csrf_token']);
        
        // Kolon ismi mapping
        $mappedData = [];
        if (isset($data['first_name'])) $mappedData['ad'] = $data['first_name'];
        if (isset($data['last_name'])) $mappedData['soyad'] = $data['last_name'];
        if (isset($data['email'])) $mappedData['email'] = $data['email'];
        if (isset($data['phone'])) $mappedData['telefon'] = $data['phone'];
        if (isset($data['tc_no'])) $mappedData['tc_kimlik'] = $data['tc_no'];
        
        // Şifre değişikliği
        if (isset($data['password']) && !empty($data['password'])) {
            $mappedData['sifre_hash'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }
        
        return $this->update($id, $mappedData);
    }
    
    
    public function verifyPassword(string $email, string $password): ?array {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return null;
        }
        
        if (!password_verify($password, $user['sifre_hash'])) {  // Eski: 'password_hash'
            return null;
        }
        
        // Eski kolon isimlerini de döndür (geriye uyumluluk için)
        $user['first_name'] = $user['ad'];
        $user['last_name'] = $user['soyad'];
        $user['password_hash'] = $user['sifre_hash'];
        $user['tc_no'] = $user['tc_kimlik'];
        $user['phone'] = $user['telefon'];
        $user['role'] = 'patient';  // Hastalar her zaman patient
        
        return $user;
    }
    
    
    public function searchByName(string $query): array {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE ad ILIKE ? OR soyad ILIKE ?
            LIMIT 50
        ");
        
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    // Geriye uyumluluk için eski metot isimleri
    public function findById($id): ?array {
        $user = parent::findById($id);
        if ($user) {
            // Eski kolon isimlerini de ekle
            $user['first_name'] = $user['ad'] ?? '';
            $user['last_name'] = $user['soyad'] ?? '';
            $user['password_hash'] = $user['sifre_hash'] ?? '';
            $user['tc_no'] = $user['tc_kimlik'] ?? '';
            $user['phone'] = $user['telefon'] ?? '';
            $user['role'] = 'patient';
        }
        return $user;
    }
}
