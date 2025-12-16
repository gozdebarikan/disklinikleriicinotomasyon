<?php


namespace App\Controllers;

use App\Services\AppointmentService;
use App\Repositories\DoctorRepository;
use App\Middleware\AuthMiddleware;
use App\Middleware\RateLimitMiddleware;
use App\Utils\Lang;
use App\Utils\Logger;

class AppointmentController {
    private $appointmentService;
    private $doctorRepo;
    
    public function __construct(AppointmentService $appointmentService, DoctorRepository $doctorRepo) {
        $this->appointmentService = $appointmentService;
        $this->doctorRepo = $doctorRepo;
    }
    
    
    public function index() {
        
        AuthMiddleware::require();
        
        $userId = AuthMiddleware::userId();
        
        
        $doctors = $this->doctorRepo->getAllActive();
        
        
        $weekOffset = isset($_GET['week']) ? (int)$_GET['week'] : 0;
        $startOfWeek = new \DateTime();
        if ($weekOffset != 0) {
            $startOfWeek->modify("$weekOffset week");
        }
        
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $d = clone $startOfWeek;
            $d->modify("+$i days");
            
            
            $dayEn = $d->format('D');
            $monthEn = $d->format('M');
            
            $dayTr = Lang::get('days.' . $dayEn);
            $monthTr = Lang::get('months.' . $monthEn);
            
            $days[] = [
                'date' => $d->format('Y-m-d'),
                'display' => $d->format('d') . ' ' . $monthTr . ' ' . $dayTr
            ];
        }
        
        
        $myAppointments = $this->appointmentService->getPatientAppointments($userId);
        
        return [
            'doctors' => $doctors,
            'weekOffset' => $weekOffset,
            'days' => $days,
            'myAppointments' => $myAppointments
        ];
    }
    
    
    public function getTakenSlots() {
        // Set JSON header first
        header('Content-Type: application/json');
        
        // API-friendly auth check - return JSON error instead of redirect
        if (!AuthMiddleware::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        try {
            
            if (empty($_GET['date']) || empty($_GET['doctor_id'])) {
                http_response_code(400);
                @ob_clean();
                echo json_encode(['error' => 'Date and doctor_id are required']);
                return;
            }
            
            // Get taken slots directly from DB
            $dbPath = __DIR__ . '/../../database/dental.sqlite';
            $db = new \PDO("sqlite:" . $dbPath);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $stmt = $db->prepare("SELECT start_time FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND status != 'cancelled'");
            $stmt->execute([$_GET['doctor_id'], $_GET['date']]);
            $taken = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            // Normalize times (e.g. 09:00:00 -> 09:00)
            $takenClean = array_map(function($t) { return substr($t, 0, 5); }, $taken);
            
            @ob_clean();
            echo json_encode(array_values($takenClean));
            
        } catch (\Exception $e) {
            Logger::error('Failed to get slots', [
                'error' => $e->getMessage(),
                'doctor_id' => $_GET['doctor_id'] ?? 'unknown',
                'date' => $_GET['date'] ?? 'unknown'
            ]);
            
            http_response_code(500);
            @ob_clean();
            echo json_encode(['error' => 'Failed to retrieve slots']);
        }
    }
    
    
    public function book() {
        // CRITICAL: Suppress ALL errors at the very start - before anything else can output
        @ob_start();
        error_reporting(0);
        ini_set('display_errors', '0');
        ini_set('html_errors', '0');
        
        // Set JSON header
        header('Content-Type: application/json; charset=utf-8');
        
        // API-friendly auth check - return JSON error instead of redirect
        if (!AuthMiddleware::check()) {
            http_response_code(401);
            @ob_end_clean();
            echo json_encode(['status' => 'error', 'message' => 'Oturum süresi dolmuş, lütfen yeniden giriş yapın.']);
            return;
        }
        
        RateLimitMiddleware::check('api');
        
        try {
            
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                http_response_code(400);
                @ob_clean();
                echo json_encode(['status' => 'error', 'message' => 'Invalid request data']);
                return;
            }
            
            $userId = AuthMiddleware::userId();
            
            
            $appointment = $this->appointmentService->bookAppointment($userId, [
                'doctor_id' => $input['doctor_id'] ?? null,
                'date' => $input['date'] ?? null,
                'time' => $input['time'] ?? null
            ]);
            
            
            Logger::logAction('Appointment booked', [
                'appointment_id' => $appointment['id'],
                'doctor_id' => $appointment['doctor_id'],
                'date' => $appointment['appointment_date']
            ]);
            
            @ob_clean();
            echo json_encode([
                'status' => 'success',
                'message' => 'Appointment booked successfully',
                'appointment' => $appointment
            ]);
            
        } catch (\Exception $e) {
            Logger::warning('Failed to book appointment', [
                'user_id' => AuthMiddleware::userId(),
                'error' => $e->getMessage()
            ]);
            
            http_response_code(400);
            @ob_clean();
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    
    public function cancel() {
        
        AuthMiddleware::require();
        
        
        RateLimitMiddleware::check('api');
        
        
        header('Content-Type: application/json');
        
        try {
            
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || empty($input['id'])) {
                http_response_code(400);
                @ob_clean();
                echo json_encode(['status' => 'error', 'message' => 'Appointment ID is required']);
                return;
            }
            
            $userId = AuthMiddleware::userId();
            
            
            $this->appointmentService->cancelAppointment($input['id'], $userId);
            
            
            Logger::logAction('Appointment cancelled', [
                'appointment_id' => $input['id']
            ]);
            
            @ob_clean();
            echo json_encode([
                'status' => 'success',
                'message' => 'Appointment cancelled successfully'
            ]);
            
        } catch (\Exception $e) {
            Logger::warning('Failed to cancel appointment', [
                'user_id' => AuthMiddleware::userId(),
                'appointment_id' => $input['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            
            http_response_code(400);
            @ob_clean();
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}