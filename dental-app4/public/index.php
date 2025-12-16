<?php
ob_start(); // Buffer all output to prevent headers/JSON issues

// CRITICAL: Suppress all errors at application start for clean API responses
error_reporting(0);
ini_set('display_errors', '0');
ini_set('html_errors', '0');

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Load Environment Variables
require_once __DIR__ . '/../app/Utils/Env.php';
\App\Utils\Env::load(__DIR__ . '/../.env');

session_start();


// PostgreSQL Database Connection
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_port = getenv('DB_PORT') ?: '5432';
$db_name = getenv('DB_DATABASE') ?: 'dental_clinic';
$db_user = getenv('DB_USERNAME') ?: 'postgres';
$db_pass = getenv('DB_PASSWORD') ?: '';

try {
    $db = new PDO(
        "pgsql:host=$db_host;port=$db_port;dbname=$db_name",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("PostgreSQL bağlantı hatası: " . $e->getMessage());
}


require_once __DIR__ . '/../app/Utils/Lang.php';
use App\Utils\Lang;
Lang::load();


function __($key) {
    return Lang::get($key);
}


function view($file, $data = []) {
    extract($data);
    $childView = __DIR__ . '/../resources/views/' . $file;
    if (strpos($file, 'auth/') === 0) {
        require $childView;
    } else {
        require __DIR__ . "/../resources/views/layout.php";
    }
}


function auth() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/dental-app4/public', '', $uri);
if (empty($uri) || $uri[0] !== '/') $uri = '/' . $uri;


require_once __DIR__ . '/../app/Utils/Lang.php';
require_once __DIR__ . '/../app/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/Middleware/CsrfMiddleware.php';
require_once __DIR__ . '/../app/Middleware/RateLimitMiddleware.php';
require_once __DIR__ . '/../app/Utils/Logger.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/AppointmentController.php';
require_once __DIR__ . '/../app/Services/AuthService.php';
require_once __DIR__ . '/../app/Services/MailService.php'; 
require_once __DIR__ . '/../app/Services/AppointmentService.php';

require_once __DIR__ . '/../app/Repositories/BaseRepository.php';
require_once __DIR__ . '/../app/Repositories/UserRepository.php';
require_once __DIR__ . '/../app/Repositories/AppointmentRepository.php';
require_once __DIR__ . '/../app/Repositories/DoctorRepository.php';


$userRepo = new App\Repositories\UserRepository($db);
$apptRepo = new App\Repositories\AppointmentRepository($db);
$doctorRepo = new App\Repositories\DoctorRepository($db);



// Services
$mailService = new App\Services\MailService(); 
$authService = new App\Services\AuthService($userRepo);
$apptService = new App\Services\AppointmentService($apptRepo, $doctorRepo, $userRepo, $mailService); 

// Controllers
$authCtrl = new App\Controllers\AuthController($authService);
$apptCtrl = new App\Controllers\AppointmentController($apptService, $doctorRepo);


if ($uri === '/login' || $uri === '/login.php') {
    $authCtrl->login();
    exit;
}

if ($uri === '/register' || $uri === '/register.php') {
    $authCtrl->register();
    exit;
}

if ($uri === '/logout') {
    session_destroy();
    header('Location: /dental-app4/public/login');
    exit;
}

if ($uri === '/lang') {
    $_SESSION['lang'] = $_GET['l'] ?? 'tr';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}

// ===== API ENDPOINTS (handle first, before auth redirect) =====
// API routes handle their own authentication and return JSON
if ($uri === '/api/slots') {
    $apptCtrl->getTakenSlots();
    exit;
}

if ($uri === '/api/book') {
    $apptCtrl->book();
    exit;
}

if ($uri === '/api/cancel') {
    $apptCtrl->cancel();
    exit;
}

// ===== PROTECTED PAGES (require auth) =====
if (!auth()) {
    header('Location: /dental-app4/public/login');
    exit;
}

if ($uri === '/' || $uri === '/index.php') {
    $data = $apptCtrl->index();
    view('calendar/index.php', $data);
    exit;
}

if ($uri === '/profile') {
    $data = $authCtrl->profile();
    view('profile/index.php', $data);
    exit;
}


http_response_code(404);
echo "Page not found";