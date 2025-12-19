# DentalApp - Kurulum Rehberi

Bu rehber, DentalApp projesini yeni bir bilgisayarda çalıştırmak için gereken adımları içerir.

---

## 📋 Gereksinimler

- **PostgreSQL 14+** (localhost:5432, şifre: admin123)
- **XAMPP** (PHP 8.0+ ile Apache)
- **.NET 8.0 SDK** (C# uygulaması için)

---

## 🚀 Kurulum Adımları

### 1. PostgreSQL Kurulumu

1. [PostgreSQL İndir](https://www.postgresql.org/download/windows/)
2. Kurulum sırasında:
   - **Şifre:** `admin123` (önemli!)
   - **Port:** `5432`
   - Stack Builder'ı atlayabilirsiniz

### 2. XAMPP Kurulumu

1. [XAMPP İndir](https://www.apachefriends.org/download.html)
2. Kurulum sonrası:
   - `C:\xampp\php\php.ini` dosyasını açın
   - Şu satırları bulup başındaki `;` işaretini kaldırın:
     ```
     extension=pdo_pgsql
     extension=pgsql
     ```

### 3. .NET 8.0 SDK Kurulumu

1. [.NET 8.0 SDK İndir](https://dotnet.microsoft.com/download/dotnet/8.0)
2. Kurulum sonrası komut satırında doğrulayın:
   ```bash
   dotnet --version
   ```

---

## 📁 Proje Dosyalarını Yerleştirme

```
C:\
├── dental-app4\           (PHP Web Uygulaması)
│   └── (tüm dosyalar)
│
└── disklinikleriicinotomasyon-main\   (C# Windows Forms)
    └── (tüm dosyalar)
```

**XAMPP için:** `dental-app4` klasörünü `C:\xampp\htdocs\` altına kopyalayın.

---

## 🗄️ Veritabanı Kurulumu

### Otomatik Kurulum (Önerilen)

1. Komut satırını açın
2. PHP klasörüne gidin:
   ```bash
   cd C:\xampp\htdocs\dental-app4
   ```
3. Veritabanını sıfırlayın:
   ```bash
   php reset_database.php
   or 
   C:\xampp\php\php.exe reset_database.php
   ```

Bu komut:
- ✅ `dental_app` veritabanını oluşturur
- ✅ Tüm tabloları oluşturur
- ✅ 8 doktor + 1 sekreter + 2 hasta ekler

---

## 👤 Test Kullanıcıları

### C# Windows Forms (Masaüstü)

| Rol | TC Kimlik | Şifre |
|-----|-----------|-------|
| Doktor | 11111111111 | 123456 |
| Sekreter | 33333333333 | 123456 |

### PHP Web Sitesi

| Rol | Email | Şifre |
|-----|-------|-------|
| Hasta | test@example.com | 123456 |
| Hasta | deneme@example.com | 123456 |

### Tüm Doktorlar (C# - TC Girişi)

| Doktor | TC Kimlik | Branş |
|--------|-----------|-------|
| Ahmet Yılmaz | 11111111111 | Genel Diş Hekimliği |
| Fatma Kaya | 11111111112 | Ortodonti |
| Ali Öztürk | 11111111113 | Periodontoloji |
| Zeynep Şahin | 11111111114 | Endodonti |
| Mustafa Çelik | 11111111115 | Pedodonti |
| Elif Arslan | 11111111116 | Ağız ve Çene Cerrahisi |
| Emre Yıldız | 11111111117 | Protetik Diş Tedavisi |
| Ayşe Koç | 11111111118 | Restoratif Diş Tedavisi |

---

## 🖥️ Uygulamaları Çalıştırma

### C# Windows Forms

```bash
cd disklinikleriicinotomasyon-main
dotnet run
```

### PHP Web Sitesi

1. XAMPP Control Panel'den **Apache** başlatın
2. Tarayıcıda açın: `http://localhost/dental-app4/public/`

---

## 🧹 Temizlik (Gereksiz Dosyaları Silme)

Eğer gereksiz dosyalar varsa bunları silebilirsiniz:

```bash
# PHP tarafında
cd C:\xampp\htdocs\dental-app4
del /s /q database\*.sqlite
del /s /q storage\logs\*.log
del /s /q storage\logs\*.txt
del /s /q storage\logs\mails\*.html
```

---

## ⚠️ Sorun Giderme

### PostgreSQL bağlantı hatası

```
SQLSTATE[08006] [7] could not connect to server
```

**Çözüm:** PostgreSQL servisinin çalıştığından emin olun:
- Windows + R → `services.msc`
- "postgresql" servisini bulun ve başlatın

### PHP PostgreSQL driver hatası

```
could not find driver
```

**Çözüm:** `php.ini` dosyasında pdo_pgsql uzantısını etkinleştirin.

---

## 📞 Bağlantı Bilgileri

| Parametre | Değer |
|-----------|-------|
| Host | 127.0.0.1 |
| Port | 5432 |
| Database | dental_app |
| Username | postgres |
| Password | admin123 |
