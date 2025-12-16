<?php 
// Use language translations if available
$langCode = $_SESSION['lang'] ?? 'tr';
?>
<!DOCTYPE html>
<html lang="<?= $langCode ?>">
<head>
    <title><?= __('menu.settings') ?? ($langCode === 'tr' ? 'Ayarlar' : 'Settings') ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<div class="app">
    <div class="sidebar">
        <h3>🦷 DentalApp</h3><br>
        <a href="/" class="nav-link"><?= __('menu.dashboard') ?? ($langCode === 'tr' ? 'Randevu Paneli' : 'Appointment Panel') ?></a>
        <a href="/settings" class="nav-link active"><?= __('menu.settings') ?? ($langCode === 'tr' ? 'Ayarlar' : 'Settings') ?></a>
        <a href="/logout" class="nav-link"><?= __('menu.logout') ?? ($langCode === 'tr' ? 'Çıkış' : 'Logout') ?></a>
    </div>
    <div class="main">
        <h2><?= __('menu.settings') ?? ($langCode === 'tr' ? 'Ayarlar' : 'Settings') ?></h2>
        <?php if(isset($_GET['saved'])): ?>
            <div style="background:#dcfce7; color:green; padding:10px; border-radius:5px;">
                <?= $langCode === 'tr' ? 'Kaydedildi!' : 'Saved!' ?>
            </div>
        <?php endif; ?>
        
        <div class="card" style="max-width:500px;">
            <form action="/settings" method="POST">
                <label><?= $langCode === 'tr' ? 'Klinik Adı' : 'Clinic Name' ?></label>
                <input type="text" name="clinic_name" value="<?= htmlspecialchars($settings['clinic_name']??'') ?>">
                
                <label><?= $langCode === 'tr' ? 'Randevu Süresi (dk)' : 'Appointment Duration (min)' ?></label>
                <select name="slot_duration">
                    <option value="15" <?= ($settings['slot_duration']=='15')?'selected':'' ?>><?= $langCode === 'tr' ? '15 Dakika' : '15 Minutes' ?></option>
                    <option value="30" <?= ($settings['slot_duration']=='30')?'selected':'' ?>><?= $langCode === 'tr' ? '30 Dakika' : '30 Minutes' ?></option>
                </select>
                
                <button class="btn"><?= __('common.save') ?? ($langCode === 'tr' ? 'Kaydet' : 'Save') ?></button>
            </form>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>