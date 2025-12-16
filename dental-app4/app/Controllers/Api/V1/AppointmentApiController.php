<?php


namespace App\Controllers\Api\V1;

use App\Services\AppointmentService;
use App\Repositories\DoctorRepository;
use App\Middleware\JwtMiddleware;
use App\Middleware\RateLimitMiddleware;
use App\Utils\ApiResponse;
use App\Utils\Logger;

class AppointmentApiController {
    private $appointmentService;
    private $doctorRepo;
    
    public function __construct(AppointmentService $appointmentService, DoctorRepository $doctorRepo) {
        $this->appointmentService = $appointmentService;
        $this->doctorRepo = $doctorRepo;
    }
    
    
    public function index() {
        RateLimitMiddleware::check('api');
        $userId = JwtMiddleware::getUserId();
        
        try {
            $status = $_GET['status'] ?? null;
            $appointments = $this->appointmentService->getPatientAppointments($userId, $status);
            
            ApiResponse::success($appointments, 'Appointments retrieved successfully');
            
        } catch (\Exception $e) {
            Logger::error('Failed to get appointments', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            ApiResponse::serverError('Failed to retrieve appointments');
        }
    }
    
    
    public function upcoming() {
        RateLimitMiddleware::check('api');
        $userId = JwtMiddleware::getUserId();
        
        try {
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
            $appointments = $this->appointmentService->getUpcomingAppointments($userId, $limit);
            
            ApiResponse::success($appointments, 'Upcoming appointments retrieved');
            
        } catch (\Exception $e) {
            ApiResponse::serverError('Failed to retrieve upcoming appointments');
        }
    }
    
    
    public function show($id) {
        RateLimitMiddleware::check('api');
        $userId = JwtMiddleware::getUserId();
        
        try {
            $appointment = $this->appointmentService->getAppointmentDetails($id);
            
            if (!$appointment) {
                ApiResponse::notFound('Appointment not found');
            }
            
            
            if ($appointment['patient_id'] != $userId) {
                ApiResponse::forbidden('Access denied');
            }
            
            ApiResponse::success($appointment);
            
        } catch (\Exception $e) {
            ApiResponse::serverError('Failed to retrieve appointment');
        }
    }
    
    
    public function store() {
        RateLimitMiddleware::check('api');
        $userId = JwtMiddleware::getUserId();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            ApiResponse::error('Invalid JSON', 400);
        }
        
        
        $required = ['doctor_id', 'date', 'time'];
        $missing = [];
        
        foreach ($required as $field) {
            if (empty($input[$field])) {
                $missing[$field] = ucfirst($field) . ' is required';
            }
        }
        
        if (!empty($missing)) {
            ApiResponse::validationError($missing);
        }
        
        try {
            $appointment = $this->appointmentService->bookAppointment($userId, [
                'doctor_id' => $input['doctor_id'],
                'date' => $input['date'],
                'time' => $input['time']
            ]);
            
            Logger::logAction('API appointment booked', [
                'appointment_id' => $appointment['id'],
                'doctor_id' => $appointment['doctor_id']
            ]);
            
            ApiResponse::created($appointment, 'Appointment booked successfully');
            
        } catch (\Exception $e) {
            Logger::warning('API appointment booking failed', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            ApiResponse::error($e->getMessage(), 400);
        }
    }
    
    
    public function destroy($id) {
        RateLimitMiddleware::check('api');
        $userId = JwtMiddleware::getUserId();
        
        try {
            $this->appointmentService->cancelAppointment($id, $userId);
            
            Logger::logAction('API appointment cancelled', [
                'appointment_id' => $id
            ]);
            
            ApiResponse::success(null, 'Appointment cancelled successfully');
            
        } catch (\Exception $e) {
            Logger::warning('API appointment cancellation failed', [
                'user_id' => $userId,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            ApiResponse::error($e->getMessage(), 400);
        }
    }
    
    
    public function doctors() {
        RateLimitMiddleware::check('api');
        JwtMiddleware::require();
        
        try {
            $doctors = $this->doctorRepo->getAllActive();
            ApiResponse::success($doctors, 'Doctors retrieved successfully');
            
        } catch (\Exception $e) {
            ApiResponse::serverError('Failed to retrieve doctors');
        }
    }
    
    
    public function availableSlots($doctorId) {
        RateLimitMiddleware::check('api');
        JwtMiddleware::require();
        
        if (empty($_GET['date'])) {
            ApiResponse::validationError(['date' => 'Date is required']);
        }
        
        try {
            $slots = $this->appointmentService->getAvailableSlots($doctorId, $_GET['date']);
            
            ApiResponse::success([
                'date' => $_GET['date'],
                'doctor_id' => $doctorId,
                'available_slots' => $slots
            ], 'Available slots retrieved');
            
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 400);
        }
    }
}
