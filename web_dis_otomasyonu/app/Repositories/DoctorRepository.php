<?php


namespace App\Repositories;

class DoctorRepository extends BaseRepository {
    protected $table = 'personel';  // Eski: 'doctors'
    
    
    public function getAllActive(): array {
        // Sadece doktorları getir (sekreterler hariç)
        $stmt = $this->db->prepare("
            SELECT id, 
                   CONCAT(ad, ' ', soyad) as name, 
                   brans as specialization,
                   ad, soyad, email, telefon, aktif
            FROM {$this->table} 
            WHERE rol = 'doktor' AND aktif = TRUE
            ORDER BY ad, soyad
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
    public function findById($id): ?array {
        $stmt = $this->db->prepare("
            SELECT id, 
                   CONCAT(ad, ' ', soyad) as name, 
                   brans as specialization,
                   ad, soyad, email, telefon, aktif, rol
            FROM {$this->table} 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    
    public function findBySpecialization(string $specialization): array {
        $stmt = $this->db->prepare("
            SELECT id, 
                   CONCAT(ad, ' ', soyad) as name, 
                   brans as specialization,
                   ad, soyad, email, telefon
            FROM {$this->table} 
            WHERE brans = ? AND rol = 'doktor' AND aktif = TRUE
        ");
        $stmt->execute([$specialization]);
        return $stmt->fetchAll();
    }
    
    
    public function searchByName(string $query): array {
        $stmt = $this->db->prepare("
            SELECT id, 
                   CONCAT(ad, ' ', soyad) as name, 
                   brans as specialization,
                   ad, soyad, email, telefon
            FROM {$this->table} 
            WHERE (ad ILIKE ? OR soyad ILIKE ?) AND rol = 'doktor'
            LIMIT 50
        ");
        
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    
    public function getDoctorStats(int|string $doctorId): ?array {
        $stmt = $this->db->prepare("
            SELECT p.id, 
                   CONCAT(p.ad, ' ', p.soyad) as name,
                   p.brans as specialization,
                   p.ad, p.soyad, p.email, p.telefon,
                   COUNT(r.id) as total_appointments,
                   COUNT(CASE WHEN r.durum = 'beklemede' OR r.durum = 'onaylandi' THEN 1 END) as active_appointments
            FROM {$this->table} p
            LEFT JOIN randevular r ON p.id = r.doktor_id
            WHERE p.id = ? AND p.rol = 'doktor'
            GROUP BY p.id, p.ad, p.soyad, p.brans, p.email, p.telefon
        ");
        
        $stmt->execute([$doctorId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    
    // TC ile doktor/sekreter bul (C# masaüstü uygulaması için)
    public function findByTcKimlik(string $tcKimlik): ?array {
        $stmt = $this->db->prepare("
            SELECT id, tc_kimlik, ad, soyad, email, telefon, sifre_hash, rol, brans, aktif
            FROM {$this->table} 
            WHERE tc_kimlik = ?
        ");
        $stmt->execute([$tcKimlik]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    
    // Şifre doğrulama (C# masaüstü uygulaması için)
    public function verifyPassword(string $tcKimlik, string $password): ?array {
        $personel = $this->findByTcKimlik($tcKimlik);
        
        if (!$personel) {
            return null;
        }
        
        if (!password_verify($password, $personel['sifre_hash'])) {
            return null;
        }
        
        // name alanı ekle (uyumluluk için)
        $personel['name'] = $personel['ad'] . ' ' . $personel['soyad'];
        $personel['specialization'] = $personel['brans'];
        
        return $personel;
    }
}
