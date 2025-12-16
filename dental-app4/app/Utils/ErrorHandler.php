<?php


namespace App\Utils;

class ErrorHandler {
    private static $isDevelopment = true;
    
    
    public static function init(): void {
        self::$isDevelopment = (getenv('APP_ENV') === 'development') || (getenv('APP_DEBUG') === 'true');
        
        
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
        
        
        if (self::$isDevelopment) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            ini_set('display_errors', '0');
        }
    }
    
    
    public static function handleError($severity, $message, $file, $line): bool {
        if (!(error_reporting() & $severity)) {
            return false;
        }
        
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }
    
    
    public static function handleException(\Throwable $e): void {
        
        Logger::error($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        
        http_response_code(500);
        
        
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => self::$isDevelopment ? $e->getMessage() : 'An error occurred',
                'debug' => self::$isDevelopment ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => explode("\n", $e->getTraceAsString())
                ] : null
            ]);
        } else {
            self::renderErrorPage($e);
        }
        
        exit;
    }
    
    
    public static function handleShutdown(): void {
        $error = error_get_last();
        
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::handleException(new \ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            ));
        }
    }
    
    
    private static function renderErrorPage(\Throwable $e): void {
        $title = self::$isDevelopment ? 'Error' : 'Something went wrong';
        $message = self::$isDevelopment ? $e->getMessage() : 'We encountered an error. Please try again later.';
        
        echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$title}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .error-container {
            background: white;
            border-radius: 24px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .error-icon {
            font-size: 4rem;
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            color: #1f2937;
            font-size: 2rem;
            margin-bottom: 10px;
            text-align: center;
        }
        .error-message {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 20px;
            text-align: center;
            line-height: 1.6;
        }
        .error-details {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #374151;
            max-height: 300px;
            overflow-y: auto;
        }
        .error-details pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 20px;
            text-align: center;
        }
        .btn:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <div class='error-icon'>⚠️</div>
        <h1>{$title}</h1>
        <div class='error-message'>{$message}</div>";
        
        if (self::$isDevelopment) {
            echo "
        <div class='error-details'>
            <strong>File:</strong> {$e->getFile()}<br>
            <strong>Line:</strong> {$e->getLine()}<br><br>
            <strong>Stack Trace:</strong>
            <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>
        </div>";
        }
        
        echo "
        <div style='text-align: center;'>
            <a href='/' class='btn'>← Go to Home</a>
        </div>
    </div>
</body>
</html>";
    }
}
