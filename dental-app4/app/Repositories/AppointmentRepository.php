<?php


namespace App\Repositories;

use PDO;

class AppointmentRepository extends BaseRepository {
    protected $table = 'randevular';  // Eski: 'appointments'
    
    
    public function findByPatient(int|string $patientId, string $status = null): array {
        // Durum mapping: 'booked' → 'beklemede'/'onaylandi', 'cancelled' → 'iptal'
        $statusMap = [
            'booked' => ['beklemede', 'onaylandi'],
            'cancelled' => ['iptal'],
            'completed' => ['tamamlandi']
        ];
        
        if ($status && isset($statusMap[$status])) {
            $placeholders = implode(',', array_fill(0, count($statusMap[$status]), '?'));
            $stmt = $this->db->prepare("
                SELECT r.*, 
                       CONCAT(p.ad, ' ', p.soyad) as doctor_name, 
                       p.brans as specialization,
                       r.randevu_tarihi as appointment_date,
                       r.randevu_saati as start_time,
                       r.durum as status,
                       r.hasta_id as patient_id,
                       r.doktor_id as doctor_id
                FROM {$this->table} r
                JOIN personel p ON r.doktor_id = p.id
                WHERE r.hasta_id = ? AND r.durum IN ($placeholders)
                ORDER BY r.randevu_tarihi DESC, r.randevu_saati DESC
            ");
            $params = array_merge([$patientId], $statusMap[$status]);
            $stmt->execute($params);
        } else {
            $stmt = $this->db->prepare("
                SELECT r.*, 
                       CONCAT(p.ad, ' ', p.soyad) as doctor_name, 
                       p.brans as specialization,
                       r.randevu_tarihi as appointment_date,
                       r.randevu_saati as start_time,
                       r.durum as status,
                       r.hasta_id as patient_id,
                       r.doktor_id as doctor_id
                FROM {$this->table} r
                JOIN personel p ON r.doktor_id = p.id
                WHERE r.hasta_id = ?
                ORDER BY r.randevu_tarihi DESC, r.randevu_saati DESC
            ");
            $stmt->execute([$patientId]);
        }
        
        return $stmt->fetchAll();
    }
    
    
    public function findByDoctor(int|string $doctorId, string $date = null): array {
        if ($date) {
            $stmt = $this->db->prepare("
                SELECT r.*, 
                       h.ad as first_name, h.soyad as last_name, h.email, h.telefon as phone,
                       r.randevu_tarihi as appointment_date,
                       r.randevu_saati as start_time,
                       r.durum as status
                FROM {$this->table} r
                JOIN hastalar h ON r.hasta_id = h.id
                WHERE r.doktor_id = ? AND r.randevu_tarihi = ?
                ORDER BY r.randevu_saati
            ");
            $stmt->execute([$doctorId, $date]);
        } else {
            $stmt = $this->db->prepare("
                SELECT r.*, 
                       h.ad as first_name, h.soyad as last_name, h.email, h.telefon as phone,
                       r.randevu_tarihi as appointment_date,
                       r.randevu_saati as start_time,
                       r.durum as status
                FROM {$this->table} r
                JOIN hastalar h ON r.hasta_id = h.id
                WHERE r.doktor_id = ?
                ORDER BY r.randevu_tarihi DESC, r.randevu_saati DESC
            ");
            $stmt->execute([$doctorId]);
        }
        
        return $stmt->fetchAll();
    }
    
    
    public function getTakenSlots(int|string $doctorId, string $date): array {
        $stmt = $this->db->prepare("
            SELECT randevu_saati as start_time 
            FROM {$this->table} 
            WHERE doktor_id = ? 
            AND randevu_tarihi = ? 
            AND durum != 'iptal'
        ");
        
        $stmt->execute([$doctorId, $date]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    
    public function isSlotAvailable(int|string $doctorId, string $date, string $time): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM {$this->table} 
            WHERE doktor_id = ? 
            AND randevu_tarihi = ? 
            AND randevu_saati = ? 
            AND durum != 'iptal'
        ");
        
        $stmt->execute([$doctorId, $date, $time]);
        return $stmt->fetchColumn() == 0;
    }
    
    
    public function createAppointment(array $data): array {
        // Eski parametre isimlerini yenilere çevir
        $doctorId = $data['doctor_id'] ?? $data['doktor_id'];
        $date = $data['appointment_date'] ?? $data['randevu_tarihi'] ?? $data['date'];
        $time = $data['start_time'] ?? $data['randevu_saati'] ?? $data['time'];
        $patientId = $data['patient_id'] ?? $data['hasta_id'];
        
        if (!$this->isSlotAvailable($doctorId, $date, $time)) {
            throw new \Exception('Bu saat dolu');
        }
        
        // Yeni formatta veri hazırla
        $newData = [
            'hasta_id' => $patientId,
            'doktor_id' => $doctorId,
            'randevu_tarihi' => $date,
            'randevu_saati' => $time,
            'durum' => 'beklemede',
            'brans' => $data['brans'] ?? null,
            'notlar' => $data['notes'] ?? $data['notlar'] ?? null
        ];
        
        $id = $this->create($newData);
        return $this->findById($id);
    }
    
    
    public function findById($id): ?array {
        $stmt = $this->db->prepare("
            SELECT r.*, 
                   CONCAT(p.ad, ' ', p.soyad) as doctor_name, 
                   p.brans as specialization,
                   r.randevu_tarihi as appointment_date,
                   r.randevu_saati as start_time,
                   r.durum as status,
                   r.hasta_id as patient_id,
                   r.doktor_id as doctor_id
            FROM {$this->table} r
            JOIN personel p ON r.doktor_id = p.id
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result) {
            // Geriye uyumluluk: end_time hesapla
            $startTime = new \DateTime($result['start_time']);
            $startTime->modify('+30 minutes');
            $result['end_time'] = $startTime->format('H:i:s');
        }
        
        return $result ?: null;
    }
    
    
    public function cancelAppointment(int|string $id, int|string $patientId): bool {
        $appointment = $this->findById($id);
        
        if (!$appointment || $appointment['hasta_id'] != $patientId) {
            throw new \Exception('Randevu bulunamadı veya erişim reddedildi');
        }
        
        // İptal süresi kontrolü
        $appointmentDateTime = strtotime($appointment['randevu_tarihi'] . ' ' . $appointment['randevu_saati']);
        $now = time();
        
        if ($appointmentDateTime - $now < 3600) {
            throw new \Exception('Randevuya 1 saatten az kaldığında iptal edilemez');
        }
        
        return $this->update($id, ['durum' => 'iptal']);
    }
    
    
    public function getUpcoming(int|string $patientId, int $limit = 5): array {
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');
        
        $stmt = $this->db->prepare("
            SELECT r.*, 
                   CONCAT(p.ad, ' ', p.soyad) as doctor_name, 
                   p.brans as specialization,
                   r.randevu_tarihi as appointment_date,
                   r.randevu_saati as start_time,
                   r.durum as status
            FROM {$this->table} r
            JOIN personel p ON r.doktor_id = p.id
            WHERE r.hasta_id = ? 
            AND r.durum IN ('beklemede', 'onaylandi')
            AND (r.randevu_tarihi > ? OR 
                 (r.randevu_tarihi = ? AND r.randevu_saati > ?))
            ORDER BY r.randevu_tarihi ASC, r.randevu_saati ASC
            LIMIT ?
        ");
        
        $stmt->execute([$patientId, $today, $today, $nowTime, $limit]);
        return $stmt->fetchAll();
    }
    
    
    public function hasActiveAppointment(int|string $patientId): bool {
        $today = date('Y-m-d');
        
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM {$this->table} 
            WHERE hasta_id = ? 
            AND durum IN ('beklemede', 'onaylandi')
            AND randevu_tarihi >= ?
        ");
        
        $stmt->execute([$patientId, $today]);
        return $stmt->fetchColumn() > 0;
    }
    
    
    public function hasAppointmentOnDate(int|string $patientId, string $date): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM {$this->table} 
            WHERE hasta_id = ? 
            AND randevu_tarihi = ? 
            AND durum != 'iptal'
        ");
        
        $stmt->execute([$patientId, $date]);
        return $stmt->fetchColumn() > 0;
    }
    
    
    public function findByDate(string $date): array {
        $stmt = $this->db->prepare("
            SELECT r.*, 
                   CONCAT(p.ad, ' ', p.soyad) as doctor_name, 
                   p.brans as specialization,
                   h.ad as first_name, h.soyad as last_name, h.email,
                   r.randevu_tarihi as appointment_date,
                   r.randevu_saati as start_time,
                   r.durum as status
            FROM {$this->table} r
            JOIN personel p ON r.doktor_id = p.id
            JOIN hastalar h ON r.hasta_id = h.id
            WHERE r.randevu_tarihi = ? 
            AND r.durum IN ('beklemede', 'onaylandi')
        ");
        
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }
}
