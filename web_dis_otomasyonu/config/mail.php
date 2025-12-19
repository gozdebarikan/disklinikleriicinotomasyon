<?php
/**
 * Mail Configuration
 * 
 * Uses Env::get() for reliable environment variable access
 */

// Ensure Env class is available
if (!class_exists('App\\Utils\\Env')) {
    require_once __DIR__ . '/../app/Utils/Env.php';
}

use App\Utils\Env;

// Load .env if not already loaded
static $envLoaded = false;
if (!$envLoaded) {
    Env::load(__DIR__ . '/../.env');
    $envLoaded = true;
}

return [
    // Default mail driver: 'smtp' for production, 'log' for development
    'default' => Env::get('MAIL_DRIVER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'host' => Env::get('MAIL_HOST', 'smtp.gmail.com'),
            'port' => (int) Env::get('MAIL_PORT', 587),
            'encryption' => Env::get('MAIL_ENCRYPTION', 'tls'),
            'username' => Env::get('MAIL_USERNAME', ''),
            'password' => Env::get('MAIL_PASSWORD', ''),
            'from_address' => Env::get('MAIL_FROM_ADDRESS', 'noreply@dentalapp.com'),
            'from_name' => Env::get('MAIL_FROM_NAME', 'DentalApp Notification System'),
        ],
    ],
];
