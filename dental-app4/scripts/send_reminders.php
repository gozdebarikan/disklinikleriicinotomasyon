<?php
/**
 * Daily Appointment Reminder Script
 * 
 * Run this script daily via cron or Task Scheduler to send reminders 
 * for appointments scheduled for tomorrow.
 * 
 * Usage: php scripts/send_reminders.php
 */

require_once __DIR__ . '/../app/Utils/Env.php';

// Manual autoloading of PHPMailer if vendor/autoload.php is missing (same logic as test_mail.php)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    $phpmailerPath = __DIR__ . '/../vendor/phpmailer/src/';
    if (file_exists($phpmailerPath . 'PHPMailer.php')) {
        require_once $phpmailerPath . 'Exception.php';
        require_once $phpmailerPath . 'PHPMailer.php';
        require_once $phpmailerPath . 'SMTP.php';
    } else {
        // Fallback for nested structure
        $phpmailerPathAlt = __DIR__ . '/../vendor/phpmailer/PHPMailer/src/';
        if (file_exists($phpmailerPathAlt . 'PHPMailer.php')) {
             require_once $phpmailerPathAlt . 'Exception.php';
             require_once $phpmailerPathAlt . 'PHPMailer.php';
             require_once $phpmailerPathAlt . 'SMTP.php';
        }
    }
}

// Load Environment
\App\Utils\Env::load(__DIR__ . '/../.env');

// Database Connection
$db_path = __DIR__ . '/../database/dental.sqlite';
try {
    $db = new PDO("sqlite:" . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\n");
}

// dependencies
require_once __DIR__ . '/../app/Repositories/BaseRepository.php';
require_once __DIR__ . '/../app/Repositories/AppointmentRepository.php';
require_once __DIR__ . '/../app/Services/MailService.php';

$apptRepo = new \App\Repositories\AppointmentRepository($db);
$mailService = new \App\Services\MailService();

// Logic
$tomorrow = date('Y-m-d', strtotime('+1 day'));
echo "Checking for appointments on: $tomorrow\n";

$appointments = $apptRepo->findByDate($tomorrow);
$count = count($appointments);

echo "Found $count appointments.\n";

foreach ($appointments as $appt) {
    // Construct patient and doctor arrays for the helper method
    $patient = [
        'first_name' => $appt['first_name'],
        'last_name' => $appt['last_name'],
        'email' => $appt['email']
    ];
    
    $doctor = [
        'name' => $appt['doctor_name'],
        'specialization' => $appt['specialization'] // Note: specialization might be missing if not joined, but repo join included it
    ];

    echo "Sending reminder to {$patient['email']}...\n";
    $mailService->sendReminder($appt, $patient, $doctor);
}

echo "Done.\n";
