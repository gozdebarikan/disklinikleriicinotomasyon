<?php


namespace App\Services;

class MailService {
    private $config;
    private $logPath;

    public function __construct() {
        $this->config = require __DIR__ . '/../../config/mail.php';
        $this->logPath = __DIR__ . '/../../storage/logs/mails';
        
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0777, true);
        }
    }

    private function logDebug($message) {
        $logFile = __DIR__ . '/../../storage/logs/mail_debug.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
    }

    
    public function send(string $to, string $subject, string $body): bool {
        $driver = $this->config['default'];
        $smtpConfig = $this->config['mailers']['smtp'];

        // Log configuration details for debugging
        $this->logDebug("=== Mail Send Attempt ===");
        $this->logDebug("To: $to");
        $this->logDebug("Subject: $subject");
        $this->logDebug("Driver: $driver");
        $this->logDebug("Host: " . ($smtpConfig['host'] ?? 'NOT SET'));
        $this->logDebug("Port: " . ($smtpConfig['port'] ?? 'NOT SET'));
        $this->logDebug("Username: " . ($smtpConfig['username'] ? '***SET***' : 'EMPTY'));
        $this->logDebug("Password: " . ($smtpConfig['password'] ? '***SET***' : 'EMPTY'));

        // Check for empty credentials
        if (empty($smtpConfig['username']) || empty($smtpConfig['password'])) {
            $this->logDebug("CRITICAL: Mail Username or Password is EMPTY. Check .env file!");
        }

        if ($driver === 'log') {
            $this->logDebug("Using LOG driver (no actual mail sent)");
            return $this->sendViaLog($to, $subject, $body);
        } elseif ($driver === 'smtp') {
            $this->logDebug("Attempting SMTP send...");
            return $this->sendViaSmtp($to, $subject, $body);
        }

        $this->logDebug("No valid driver found: $driver");
        return false;
    }

    
    private function sendViaLog(string $to, string $subject, string $body): bool {
        $filename = date('Y-m-d_H-i-s') . '_' . uniqid() . '.html';
        $filepath = $this->logPath . '/' . $filename;

        $content = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>$subject</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header { background: #4f46e5; color: white; padding: 15px; border-radius: 6px 6px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #666; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        .meta { background: #f9fafb; padding: 10px; border-radius: 4px; font-size: 13px; margin-bottom: 20px; border-left: 4px solid #4f46e5; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>DentalApp Notification</h2>
        </div>
        <div class='content'>
            <div class='meta'>
                <strong>To:</strong> $to<br>
                <strong>Subject:</strong> $subject<br>
                <strong>Date:</strong> " . date('Y-m-d H:i:s') . "
            </div>
            $body
        </div>
        <div class='footer'>
            &copy; " . date('Y') . " DentalApp Clinic Management System
        </div>
    </div>
</body>
</html>";

        return file_put_contents($filepath, $content) !== false;
    }

    
    private function sendViaSmtp(string $to, string $subject, string $body): bool {
        // Manual fallback for PHPMailer since autoloader is missing in index.php
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
             // Path based on verified directory structure: 
             // current dir: app/Services
             // root: ../../
             // vendor: ../../vendor/phpmailer/src/
             $vendorPath = __DIR__ . '/../../vendor/phpmailer/src/';
             
             if (file_exists($vendorPath . 'PHPMailer.php')) {
                 require_once $vendorPath . 'Exception.php';
                 require_once $vendorPath . 'PHPMailer.php';
                 require_once $vendorPath . 'SMTP.php';
                 $this->logDebug("Manually loaded PHPMailer from $vendorPath");
             } else {
                 $this->logDebug("CRITICAL: PHPMailer files NOT found at $vendorPath");
             }
        }

        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $this->logDebug("CRITICAL: PHPMailer class not found after manual load attempt.");
            return $this->sendViaLog($to, "[SMTP FAILED - NO CLASS] $subject", $body);
        }

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $config = $this->config['mailers']['smtp'];

            // Server settings
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = $config['encryption'];
            $mail->Port       = $config['port'];
            $mail->CharSet    = 'UTF-8';

            // Recipients
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            
            // Log success using both standard Logger and debug log for redundancy
            \App\Utils\Logger::info("Mail sent successfully to $to", ['subject' => $subject]);
            $this->logDebug("SUCCESS: Mail sent to $to");
            return true;
        } catch (\Exception $e) {
            // Log detailed error
            \App\Utils\Logger::error("SMTP Error sending to $to", [
                'error' => $e->getMessage(), 
                'subject' => $subject
            ]);
            $this->logDebug("SMTP ERROR: " . $e->getMessage());
            
            // Still fallback to log file for content preservation
            $this->sendViaLog($to, "[SMTP ERROR] $subject", $body . "<br><br><strong>SMTP Error:</strong> " . $e->getMessage());
            return false;
        }
    }

    

    public function sendAppointmentCreated(array $appointment, array $patient, array $doctor) {
        $subject = "Randevu Talebiniz Oluşturuldu";
        $body = "
            <h3>Sayın {$patient['first_name']} {$patient['last_name']},</h3>
            <p>Randevu talebiniz oluşturuldu.</p>
            <ul>
                <li><strong>Doktor:</strong> Dr. {$doctor['name']}</li>
                <li><strong>Tarih:</strong> {$appointment['appointment_date']}</li>
                <li><strong>Saat:</strong> {$appointment['start_time']}</li>
                <li><strong>Branş:</strong> {$doctor['specialization']}</li>
            </ul>
        ";
        return $this->send($patient['email'], $subject, $body);
    }

    public function sendAppointmentCancelled(array $appointment, array $patient, array $doctor) {
        $subject = "Randevu Talebiniz İptal Edildi";
        $body = "
            <h3>Sayın {$patient['first_name']} {$patient['last_name']},</h3>
            <p>Randevu talebiniz iptal edildi.</p>
            <ul>
                <li><strong>Doktor:</strong> Dr. {$doctor['name']}</li>
                <li><strong>Tarih:</strong> {$appointment['appointment_date']}</li>
                <li><strong>Saat:</strong> {$appointment['start_time']}</li>
            </ul>
        ";
        return $this->send($patient['email'], $subject, $body);
    }

    public function sendReminder(array $appointment, array $patient, array $doctor) {
        $subject = "Randevu Hatırlatması";
        $body = "
            <h3>Sayın {$patient['first_name']} {$patient['last_name']},</h3>
            <p>Yarın randevunuz bulunmaktadır.</p>
            <ul>
                <li><strong>Doktor:</strong> Dr. {$doctor['name']}</li>
                <li><strong>Tarih:</strong> {$appointment['appointment_date']}</li>
                <li><strong>Saat:</strong> {$appointment['start_time']}</li>
            </ul>
            <p>Sizi kliniğimizde görmekten mutluluk duyarız.</p>
        ";
        return $this->send($patient['email'], $subject, $body);
    }
}
