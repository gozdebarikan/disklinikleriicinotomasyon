<?php
namespace App\Utils;

class Env {
    /**
     * Load .env file variables into environment
     */
    public static function load(string $path): void {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Split name and value
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                // Remove quotes if present
                $value = trim($value, "\"'");

                // Always overwrite to ensure .env takes precedence
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    /**
     * Get environment variable
     */
    public static function get(string $key, mixed $default = null): mixed {
        // Check $_ENV, $_SERVER, then getenv()
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        return $value !== false && $value !== null ? $value : $default;
    }
}
