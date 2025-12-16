<?php


namespace App\Utils;

class SeoHelper {
    private static $title = 'Dental App - Modern Randevu Sistemi';
    private static $description = 'Diş hekimi randevularınızı kolayca yönetin. Modern, hızlı ve güvenli online randevu sistemi.';
    private static $keywords = 'diş hekimi, randevu, dental, diş kliniği, online randevu, sağlık';
    private static $image = '/images/og-image.jpg';
    private static $url = '';
    
    
    public static function init(): void {
        self::$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") 
                    . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    
    
    public static function setTitle(string $title): void {
        self::$title = $title . ' - Dental App';
    }
    
    
    public static function setDescription(string $description): void {
        self::$description = $description;
    }
    
    
    public static function setKeywords(string $keywords): void {
        self::$keywords = $keywords;
    }
    
    
    public static function setImage(string $image): void {
        self::$image = $image;
    }
    
    
    public static function renderMetaTags(): string {
        self::init();
        
        $output = '';
        
        
        $output .= '<meta name="description" content="' . htmlspecialchars(self::$description) . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . htmlspecialchars(self::$keywords) . '">' . PHP_EOL;
        $output .= '<meta name="author" content="Dental App">' . PHP_EOL;
        
        
        $output .= '<meta property="og:title" content="' . htmlspecialchars(self::$title) . '">' . PHP_EOL;
        $output .= '<meta property="og:description" content="' . htmlspecialchars(self::$description) . '">' . PHP_EOL;
        $output .= '<meta property="og:type" content="website">' . PHP_EOL;
        $output .= '<meta property="og:url" content="' . htmlspecialchars(self::$url) . '">' . PHP_EOL;
        $output .= '<meta property="og:image" content="' . htmlspecialchars(self::$image) . '">' . PHP_EOL;
        $output .= '<meta property="og:locale" content="tr_TR">' . PHP_EOL;
        
        
        $output .= '<meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
        $output .= '<meta name="twitter:title" content="' . htmlspecialchars(self::$title) . '">' . PHP_EOL;
        $output .= '<meta name="twitter:description" content="' . htmlspecialchars(self::$description) . '">' . PHP_EOL;
        $output .= '<meta name="twitter:image" content="' . htmlspecialchars(self::$image) . '">' . PHP_EOL;
        
        
        $output .= '<meta name="mobile-web-app-capable" content="yes">' . PHP_EOL;
        $output .= '<meta name="apple-mobile-web-app-capable" content="yes">' . PHP_EOL;
        $output .= '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . PHP_EOL;
        $output .= '<meta name="theme-color" content="#4f46e5">' . PHP_EOL;
        
        return $output;
    }
    
    
    public static function generateStructuredData(): string {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            'name' => 'Dental App',
            'description' => self::$description,
            'url' => self::$url,
            'image' => self::$image,
            'priceRange' => '$$',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'TR'
            ],
            'medicalSpecialty' => 'Dentistry'
        ];
        
        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    }
    
    
    public static function generateBreadcrumb(array $items): string {
        $itemListElement = [];
        
        foreach ($items as $index => $item) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? self::$url
            ];
        }
        
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        ];
        
        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    }
}
