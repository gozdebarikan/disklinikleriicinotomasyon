<?php


namespace App\Utils;

class ApiResponse {
    
    public static function success($data = null, string $message = 'Success', int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ];
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    
    public static function error(string $message = 'Error', int $statusCode = 400, $errors = null): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        
        $response = [
            'success' => false,
            'message' => $message,
            'timestamp' => time()
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    
    public static function validationError(array $errors, string $message = 'Validation failed'): void {
        self::error($message, 422, $errors);
    }
    
    
    public static function unauthorized(string $message = 'Unauthorized'): void {
        self::error($message, 401);
    }
    
    
    public static function forbidden(string $message = 'Forbidden'): void {
        self::error($message, 403);
    }
    
    
    public static function notFound(string $message = 'Resource not found'): void {
        self::error($message, 404);
    }
    
    
    public static function serverError(string $message = 'Internal server error'): void {
        self::error($message, 500);
    }
    
    
    public static function paginated(array $data, int $total, int $page, int $perPage): void {
        $totalPages = ceil($total / $perPage);
        
        $response = [
            'success' => true,
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => $totalPages,
                'has_more' => $page < $totalPages
            ],
            'timestamp' => time()
        ];
        
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    
    public static function created($data, string $message = 'Resource created'): void {
        self::success($data, $message, 201);
    }
    
    
    public static function noContent(): void {
        http_response_code(204);
        exit;
    }
}
