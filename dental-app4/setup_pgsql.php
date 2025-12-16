<?php
// =====================================================
// PostgreSQL BİRLEŞİK KURULUM SCRIPTI
// C# Masaüstü + PHP Web Uygulaması için
// =====================================================
// Çalıştır: php setup_pgsql.php

require_once __DIR__ . '/app/Utils/Env.php';
\App\Utils\Env::load(__DIR__ . '/.env');

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_DATABASE') ?: 'dental_clinic';
$user = getenv('DB_USERNAME') ?: 'postgres';
$pass = getenv('DB_PASSWORD') ?: '';

echo "🦷 DentalApp PostgreSQL Kurulum Scripti\n";
echo "========================================\n\n";

try {
    // 1. Veritabanı oluştur (postgres'e bağlanarak)
    echo "📦 Veritabanı kontrol ediliyor...\n";
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$db'");
    if (!$stmt->fetch()) {
        $pdo->exec("CREATE DATABASE $db");
        echo "✅ Veritabanı '$db' oluşturuldu.\n";
    } else {
        echo "ℹ️ Veritabanı '$db' zaten mevcut.\n";
    }

    // 2. Hedef veritabanına bağlan
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Tabloları oluştur
    echo "\n📋 Tablolar oluşturuluyor...\n";
    
    $tables = [
        // Personel Tablosu (Doktor + Sekreter) - C# Masaüstü için
        "personel" => "
            CREATE TABLE IF NOT EXISTS personel (
                id SERIAL PRIMARY KEY,
                tc_kimlik VARCHAR(11) UNIQUE NOT NULL,
                ad VARCHAR(50) NOT NULL,
                soyad VARCHAR(50) NOT NULL,
                email VARCHAR(100) UNIQUE,
                telefon VARCHAR(15),
                sifre_hash VARCHAR(255) NOT NULL,
                rol VARCHAR(20) NOT NULL CHECK (rol IN ('doktor', 'sekreter')),
                brans VARCHAR(50),
                aktif BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        // Hastalar Tablosu - Web için
        "hastalar" => "
            CREATE TABLE IF NOT EXISTS hastalar (
                id SERIAL PRIMARY KEY,
                tc_kimlik VARCHAR(11) UNIQUE,
                ad VARCHAR(50) NOT NULL,
                soyad VARCHAR(50) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                telefon VARCHAR(15),
                adres TEXT,
                dogum_tarihi DATE,
                cinsiyet VARCHAR(10) CHECK (cinsiyet IN ('erkek', 'kadin', 'diger')),
                sifre_hash VARCHAR(255) NOT NULL,
                aktif BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        // Randevular Tablosu
        "randevular" => "
            CREATE TABLE IF NOT EXISTS randevular (
                id SERIAL PRIMARY KEY,
                hasta_id INTEGER NOT NULL REFERENCES hastalar(id) ON DELETE CASCADE,
                doktor_id INTEGER NOT NULL REFERENCES personel(id),
                randevu_tarihi DATE NOT NULL,
                randevu_saati TIME NOT NULL,
                brans VARCHAR(50),
                durum VARCHAR(20) DEFAULT 'beklemede' 
                    CHECK (durum IN ('beklemede', 'onaylandi', 'tamamlandi', 'iptal')),
                notlar TEXT,
                iptal_nedeni TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE(doktor_id, randevu_tarihi, randevu_saati)
            )
        ",
        
        // Muayeneler Tablosu - C# Doktor Paneli için
        "muayeneler" => "
            CREATE TABLE IF NOT EXISTS muayeneler (
                id SERIAL PRIMARY KEY,
                randevu_id INTEGER REFERENCES randevular(id),
                hasta_id INTEGER NOT NULL REFERENCES hastalar(id),
                doktor_id INTEGER NOT NULL REFERENCES personel(id),
                islem_yapilan_dis VARCHAR(50),
                tani TEXT,
                recete TEXT,
                tedavi_durumu VARCHAR(50),
                muayene_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        // Duyurular Tablosu - C# için
        "duyurular" => "
            CREATE TABLE IF NOT EXISTS duyurular (
                id SERIAL PRIMARY KEY,
                gonderen_id INTEGER NOT NULL REFERENCES personel(id),
                alici_rol VARCHAR(50),
                icerik TEXT NOT NULL,
                okundu BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        // Ayarlar Tablosu
        "ayarlar" => "
            CREATE TABLE IF NOT EXISTS ayarlar (
                id SERIAL PRIMARY KEY,
                anahtar VARCHAR(50) UNIQUE NOT NULL,
                deger TEXT,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        "
    ];

    foreach ($tables as $name => $sql) {
        $pdo->exec($sql);
        echo "   ✓ $name tablosu oluşturuldu\n";
    }

    // 4. Index'ler (performans için)
    echo "\n🔍 Index'ler oluşturuluyor...\n";
    
    $indexes = [
        "CREATE INDEX IF NOT EXISTS idx_personel_rol ON personel(rol)",
        "CREATE INDEX IF NOT EXISTS idx_personel_tc ON personel(tc_kimlik)",
        "CREATE INDEX IF NOT EXISTS idx_hastalar_email ON hastalar(email)",
        "CREATE INDEX IF NOT EXISTS idx_hastalar_tc ON hastalar(tc_kimlik)",
        "CREATE INDEX IF NOT EXISTS idx_randevular_tarih ON randevular(randevu_tarihi)",
        "CREATE INDEX IF NOT EXISTS idx_randevular_doktor ON randevular(doktor_id)",
        "CREATE INDEX IF NOT EXISTS idx_randevular_hasta ON randevular(hasta_id)",
        "CREATE INDEX IF NOT EXISTS idx_randevular_durum ON randevular(durum)"
    ];

    foreach ($indexes as $sql) {
        $pdo->exec($sql);
    }
    echo "   ✓ Tüm index'ler oluşturuldu\n";

    // 5. Varsayılan veriler
    echo "\n📥 Varsayılan veriler ekleniyor...\n";
    
    // BCrypt hash for '123456'
    $passHash = password_hash('123456', PASSWORD_BCRYPT);
    
    // Varsayılan ayarlar
    $stmt = $pdo->query("SELECT COUNT(*) FROM ayarlar");
    if ($stmt->fetchColumn() == 0) {
        $ayarlar = [
            ['klinik_adi', 'DentalApp Kliniği'],
            ['randevu_suresi', '30'],
            ['calisma_baslangic', '09:00'],
            ['calisma_bitis', '18:00']
        ];
        $stmt = $pdo->prepare("INSERT INTO ayarlar (anahtar, deger) VALUES (?, ?)");
        foreach ($ayarlar as $ayar) {
            $stmt->execute($ayar);
        }
        echo "   ✓ Ayarlar eklendi\n";
    }
    
    // Varsayılan personel (doktor + sekreter)
    $stmt = $pdo->query("SELECT COUNT(*) FROM personel");
    if ($stmt->fetchColumn() == 0) {
        $personeller = [
            ['11111111111', 'Ahmet', 'Yılmaz', 'ahmet@klinik.com', $passHash, 'doktor', 'Genel Diş Hekimliği'],
            ['22222222222', 'Fatma', 'Kaya', 'fatma@klinik.com', $passHash, 'doktor', 'Ortodonti'],
            ['33333333333', 'Mehmet', 'Demir', 'mehmet@klinik.com', $passHash, 'sekreter', null]
        ];
        $stmt = $pdo->prepare("INSERT INTO personel (tc_kimlik, ad, soyad, email, sifre_hash, rol, brans) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($personeller as $p) {
            $stmt->execute($p);
        }
        echo "   ✓ Doktor ve Sekreter hesapları eklendi\n";
    }
    
    // Varsayılan test hastası
    $stmt = $pdo->query("SELECT COUNT(*) FROM hastalar");
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO hastalar (tc_kimlik, ad, soyad, email, telefon, sifre_hash) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(['44444444444', 'Test', 'Hasta', 'test@example.com', '5551234567', $passHash]);
        echo "   ✓ Test hasta hesabı eklendi\n";
    }

    echo "\n========================================\n";
    echo "🎉 KURULUM TAMAMLANDI!\n";
    echo "========================================\n\n";
    
    echo "📋 Test Kullanıcıları:\n";
    echo "   Doktor:   TC: 11111111111, Şifre: 123456\n";
    echo "   Doktor:   TC: 22222222222, Şifre: 123456\n";
    echo "   Sekreter: TC: 33333333333, Şifre: 123456\n";
    echo "   Hasta:    Email: test@example.com, Şifre: 123456\n\n";
    
    echo "🔗 Bağlantı Bilgileri:\n";
    echo "   Host: $host\n";
    echo "   Port: $port\n";
    echo "   Database: $db\n";
    echo "   User: $user\n\n";

} catch (PDOException $e) {
    echo "\n❌ HATA: " . $e->getMessage() . "\n";
    echo "\n💡 Olası çözümler:\n";
    echo "   1. PostgreSQL servisinin çalıştığından emin olun\n";
    echo "   2. .env dosyasındaki bağlantı bilgilerini kontrol edin\n";
    echo "   3. Kullanıcı adı ve şifrenin doğru olduğundan emin olun\n";
    exit(1);
}
