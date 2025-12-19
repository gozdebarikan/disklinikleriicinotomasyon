<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'tr' ?>">
<head><title>Panel</title><link rel="stylesheet" href="/css/main.css"></head>
<body>
<div class="app">
    <div class="sidebar">
        <h3>🦷 DentalApp</h3>
        <br>
        <a href="/" class="nav-link active"><?= __('dash') ?></a>
        <a href="/settings" class="nav-link"><?= __('settings') ?></a>
        <a href="/logout" class="nav-link"><?= __('logout') ?></a>
        
        <div style="margin-top:auto;">
            <a href="/lang?l=tr">TR</a> | <a href="/lang?l=en">EN</a>
            <button id="theme-toggle" class="btn" style="background:#444; font-size:12px;">🌙 Tema</button>
        </div>
    </div>
    
    <div class="main">
        <h2 style="margin-bottom:20px;">Hoşgeldin, <?= $_SESSION['user_name'] ?></h2>

        <div class="card">
            <h3>📅 Randevu Durumu (Bu Hafta)</h3>
            <div class="grid">
                <?php foreach($calendarData as $d): ?>
                    <div class="day-box <?= $d['is_full']?'full':'avail' ?>" 
                         onclick="<?= $d['is_full']?'':"openSlot('{$d['date']}','{$d['display']}')" ?>">
                        <h3><?= $d['display'] ?></h3>
                        <small><?= $d['is_full'] ? 'DOLU' : 'Müsait' ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <h3>📌 Randevularım</h3>
            <table width="100%" style="margin-top:15px; border-collapse:collapse;">
                <tr style="text-align:left; border-bottom:1px solid #ddd;">
                    <th>Tarih</th><th>Saat</th><th>Doktor</th>
                </tr>
                <?php foreach($myAppointments as $app): ?>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:10px;"><?= $app['appointment_date'] ?></td>
                    <td><?= $app['start_time'] ?></td>
                    <td><?= $app['dname'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div id="slot-modal" class="modal hidden">
    <div class="modal-content">
        <span onclick="closeModals()" class="close">&times;</span>
        <h3 id="modal-title"></h3>
        <p>Lütfen saat seçin:</p>
        <div id="slots" class="slots"></div>
        <input type="hidden" id="date-input">
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>