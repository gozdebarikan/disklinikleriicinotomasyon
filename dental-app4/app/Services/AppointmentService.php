<?php


namespace App\Services;

use App\Repositories\AppointmentRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\UserRepository;
use App\Services\MailService;
use App\Utils\Logger;

class AppointmentService {
    private $appointmentRepo;
    private $doctorRepo;
    private $userRepo;
    private $mailService;

    public function __construct(
        AppointmentRepository $appointmentRepo, 
        DoctorRepository $doctorRepo, 
        UserRepository $userRepo,
        MailService $mailService
    ) {
        $this->appointmentRepo = $appointmentRepo;
        $this->doctorRepo = $doctorRepo;
        $this->userRepo = $userRepo;
        $this->mailService = $mailService;
    }

    public function bookAppointment($patientId, array $data) {
        try {
            // Check availability first
            $takenSlots = $this->appointmentRepo->getTakenSlots($data['doctor_id'], $data['date']);
            // Convert time to HH:SS format if needed, but usually it's HH:00
            // Assuming data['time'] is like '09:00'
            // Simple check
            if (in_array($data['time'], $takenSlots) || in_array($data['time'] . ':00', $takenSlots)) {
                 throw new \Exception('Selected time slot is already taken.');
            }

            // Create appointment
            $appointmentData = [
                'patient_id' => $patientId,
                'doctor_id' => $data['doctor_id'],
                'appointment_date' => $data['date'],
                'start_time' => $data['time'],
                'status' => 'confirmed' // Default status
            ];

            if ($this->appointmentRepo->hasAppointmentOnDate($patientId, $data['date'])) {
                throw new \Exception('Seçilen tarihte zaten bir randevunuz bulunmaktadır.');
            }

            $appointment = $this->appointmentRepo->createAppointment($appointmentData);

            // Fetch Doctor for email context
            $doctor = $this->doctorRepo->findById($data['doctor_id']);

            Logger::info("Appointment created, attempting to send mail...", [
                'appt_id' => $appointment['id'], 
                'patient_id' => $patientId
            ]);
            
            try {
                $patient = $this->userRepo->findById($patientId);
                
                // Debug: Log patient and doctor data
                Logger::info("Mail prep - Patient data", [
                    'patient_email' => $patient['email'] ?? 'NO_EMAIL',
                    'patient_name' => ($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? '')
                ]);
                Logger::info("Mail prep - Doctor data", [
                    'doctor_name' => $doctor['name'] ?? 'NO_NAME',
                    'doctor_spec' => $doctor['specialization'] ?? 'NO_SPEC'
                ]);
                
                if ($patient && $doctor) {
                    try {
                        $mailResult = $this->mailService->sendAppointmentCreated($appointment, $patient, $doctor);
                        Logger::info("Mail send result: " . ($mailResult ? "SUCCESS" : "FAILED"));
                    } catch (\Throwable $e) {
                        Logger::error("Mail failed strictly caught: " . $e->getMessage());
                    }
                } else {
                    Logger::warning("Patient or Doctor not found for mail", ['p' => !!$patient, 'd' => !!$doctor]);
                }
            } catch (\Exception $e) {
                Logger::error("Mail sending failed (Created): " . $e->getMessage());
            }
            
            return $appointment;
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to book appointment: ' . $e->getMessage());
        }
    }
    
    
    public function cancelAppointment(int|string $appointmentId, int|string $patientId): bool {
        try {
            
            $appointment = $this->appointmentRepo->findById($appointmentId);
            
            $result = $this->appointmentRepo->cancelAppointment($appointmentId, $patientId);
            
            if ($result) {
                Logger::info("Appointment cancelled, preparing to send mail...", [
                    'appointment_id' => $appointmentId,
                    'patient_id' => $patientId
                ]);
                
                try {
                    $patient = $this->userRepo->findById($patientId);
                    $doctor = $this->doctorRepo->findById($appointment['doctor_id']);
                    
                    Logger::info("Cancel mail prep", [
                        'patient_email' => $patient['email'] ?? 'NO_EMAIL',
                        'doctor_name' => $doctor['name'] ?? 'NO_NAME'
                    ]);

                    if ($patient && $doctor) {
                        $mailResult = $this->mailService->sendAppointmentCancelled($appointment, $patient, $doctor);
                        Logger::info("Cancel mail send result: " . ($mailResult ? "SUCCESS" : "FAILED"));
                    } else {
                        Logger::warning("Cancel: Patient or Doctor missing for mail");
                    }
                } catch (\Exception $e) {
                    Logger::error("Mail sending failed (Cancelled): " . $e->getMessage());
                }
            } else {
                Logger::warning("Cancel: Repo returned false for appointment $appointmentId");
            }
            
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Failed to cancel appointment: ' . $e->getMessage());
        }
    }
    
    
    public function getAvailableSlots(int|string $doctorId, string $date): array {
        
        $workingHours = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
        
        
        $takenSlots = $this->appointmentRepo->getTakenSlots($doctorId, $date);
        
        
        $availableSlots = [];
        $now = time();
        
        foreach ($workingHours as $time) {
            $slotDateTime = strtotime($date . ' ' . $time);
            
            
            if ($slotDateTime < $now) {
                continue;
            }
            
            
            if (in_array($time . ':00', $takenSlots) || in_array($time, $takenSlots)) {
                continue;
            }
            
            $availableSlots[] = $time;
        }
        
        return $availableSlots;
    }
    
    
    public function getPatientAppointments(int|string $patientId, string $status = null): array {
        return $this->appointmentRepo->findByPatient($patientId, $status);
    }
    
    
    public function getUpcomingAppointments(int|string $patientId, int $limit = 5): array {
        return $this->appointmentRepo->getUpcoming($patientId, $limit);
    }
    
    
    public function getDoctorAppointments(int|string $doctorId, string $date = null): array {
        return $this->appointmentRepo->findByDoctor($doctorId, $date);
    }
    
    
    public function getAppointmentDetails(int|string $appointmentId): ?array {
        return $this->appointmentRepo->findById($appointmentId);
    }
    
    
    public function rescheduleAppointment(
        int|string $appointmentId,
        int|string $patientId,
        string $newDate,
        string $newTime
    ): array {
        
        $this->cancelAppointment($appointmentId, $patientId);
        
        
        $oldAppointment = $this->appointmentRepo->findById($appointmentId);
        
        
        return $this->bookAppointment($patientId, [
            'doctor_id' => $oldAppointment['doctor_id'],
            'date' => $newDate,
            'time' => $newTime
        ]);
    }
}
