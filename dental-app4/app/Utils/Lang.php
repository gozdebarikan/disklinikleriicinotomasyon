<?php

namespace App\Utils;

class Lang {
    private static $translations = [];

    public static function load() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $lang = $_SESSION['lang'] ?? 'tr';
        
        $file = __DIR__ . "/../../resources/lang/{$lang}.php";
        if (file_exists($file)) {
            self::$translations = include $file;
        } else {
            self::$translations = include __DIR__ . "/../../resources/lang/tr.php";
        }
    }

    public static function get($key) {
        $keys = explode('.', $key);
        $value = self::$translations;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $key; 
            }
        }
        return is_array($value) || is_string($value) ? $value : $key;
    }
}


function __($key) {
    return Lang::get($key);
}