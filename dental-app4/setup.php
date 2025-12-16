<?php

ini_set('display_errors', 1); error_reporting(E_ALL);

$config = require 'config/database.php';
$dbPath = $config['database_path'];
$dbFolder = dirname($dbPath);

if (!is_dir($dbFolder)) mkdir($dbFolder, 0777, true);
if (file_exists($dbPath)) unlink($dbPath);

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $commands = [
        "CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tc_no TEXT UNIQUE,
            first_name TEXT,
            last_name TEXT,
            email TEXT UNIQUE,
            password_hash TEXT,
            role TEXT DEFAULT 'patient',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE doctors (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            specialization TEXT
        )",
        "CREATE TABLE appointments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            patient_id INTEGER,
            doctor_id INTEGER,
            appointment_date DATE,
            start_time TIME,
            end_time TIME,
            status TEXT DEFAULT 'booked', -- booked, cancelled
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE settings (
            key_name TEXT PRIMARY KEY,
            value_text TEXT
        )"
    ];

    foreach ($commands as $sql) $pdo->exec($sql);

    
    $pass = password_hash('123456', PASSWORD_BCRYPT);
    
    
    $pdo->exec("INSERT INTO users (tc_no, first_name, last_name, email, password_hash) VALUES ('11111111111', 'Test', 'Hasta', 'test@example.com', '$pass')");
    $pdo->exec("INSERT INTO users (tc_no, first_name, last_name, email, password_hash, role) VALUES ('22222222222', 'Admin', 'User', 'admin@example.com', '$pass', 'admin')");

    
    $pdo->exec("INSERT INTO doctors (name, specialization) VALUES ('Dr. Ahmet Yılmaz', 'Ortodonti'), ('Dr. Ayşe Demir', 'Cerrahi'), ('Dr. John Doe', 'Pedodonti')");

    echo "✅ Kurulum Başarılı! \nKullanıcı: test@example.com / 123456\n";

} catch (PDOException $e) { die("Hata: " . $e->getMessage()); }