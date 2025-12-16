<?php


use App\Controllers\Api\V1\AuthApiController;
use App\Controllers\Api\V1\AppointmentApiController;
use App\Utils\ApiResponse;


$authApiController = new AuthApiController($authService);
$appointmentApiController = new AppointmentApiController($appointmentService, $doctorRepo);


$method = $_SERVER['REQUEST_METHOD'];
$path = preg_replace('#^/api/v1/?#', '', $uri);


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}





if ($path === 'auth/login' && $method === 'POST') {
    $authApiController->login();
    exit;
}

if ($path === 'auth/register' && $method === 'POST') {
    $authApiController->register();
    exit;
}

if ($path === 'auth/refresh' && $method === 'POST') {
    $authApiController->refresh();
    exit;
}

if ($path === 'auth/me' && $method === 'GET') {
    $authApiController->me();
    exit;
}





if ($path === 'appointments' && $method === 'GET') {
    $appointmentApiController->index();
    exit;
}

if ($path === 'appointments/upcoming' && $method === 'GET') {
    $appointmentApiController->upcoming();
    exit;
}

if ($path === 'appointments' && $method === 'POST') {
    $appointmentApiController->store();
    exit;
}

if (preg_match('#^appointments/(\d+)$#', $path, $matches) && $method === 'GET') {
    $appointmentApiController->show($matches[1]);
    exit;
}

if (preg_match('#^appointments/(\d+)$#', $path, $matches) && $method === 'DELETE') {
    $appointmentApiController->destroy($matches[1]);
    exit;
}





if ($path === 'doctors' && $method === 'GET') {
    $appointmentApiController->doctors();
    exit;
}

if (preg_match('#^doctors/(\d+)/slots$#', $path, $matches) && $method === 'GET') {
    $appointmentApiController->availableSlots($matches[1]);
    exit;
}





ApiResponse::notFound('API endpoint not found');
