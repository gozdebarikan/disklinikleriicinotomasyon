<?php
// PHP OPCache temizleme scripti
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        echo "✅ PHP OPCache başarıyla temizlendi!<br>";
        echo "Artık yapılan değişiklikleri görebilirsiniz.";
    } else {
        echo "❌ OPCache temizlenemedi.";
    }
} else {
    echo "ℹ️ OPCache yüklü veya aktif değil (Bu durumda değişiklikleri hemen görmeniz lazımdı).";
}
echo "<br><br><a href='/dental-app4/public/'>Ana Sayfaya Dön</a>";
