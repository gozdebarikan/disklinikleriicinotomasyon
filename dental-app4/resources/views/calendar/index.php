<?php 

if (!isset($days)) $days = [];
if (!isset($doctors)) $doctors = [];
if (!isset($myAppointments)) $myAppointments = [];
if (!isset($weekOffset)) $weekOffset = 0;


$totalAppointments = count($myAppointments);
$activeAppointments = count(array_filter($myAppointments, fn($a) => $a['status'] !== 'cancelled'));
$cancelledAppointments = $totalAppointments - $activeAppointments;
?>

<!-- Page Header -->
<div class="page-header">
    <h1><?= __('dash.welcome') ?>, <?= $_SESSION['user_name'] ?? 'Misafir' ?>! 👋 <span style="font-size:0.8rem; opacity:0.5;">(v1.2)</span></h1>
    <p><?= __('dash.subtitle') ?></p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed); color:white;">
            <i class="ri-calendar-check-fill"></i>
        </div>
        <div class="stat-value"><?= $activeAppointments ?></div>
        <div class="stat-label"><?= __('dash.active') ?> <?= __('dash.my_appointments') ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#22c55e,#16a34a); color:white;">
            <i class="ri-calendar-line"></i>
        </div>
        <div class="stat-value"><?= $totalAppointments ?></div>
        <div class="stat-label"><?= __('dash.total_appointments') ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706); color:white;">
            <i class="ri-user-heart-fill"></i>
        </div>
        <div class="stat-value"><?= count($doctors) ?></div>
        <div class="stat-label"><?= __('dash.doctor') ?></div>
    </div>
</div>

<!-- Doctor Selection Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="ri-stethoscope-line"></i>
            <?= __('dash.select_doctor') ?>
        </div>
    </div>
    <select id="doctor-select" onchange="updateCalendar()" style="width:100%; max-width:400px; padding:14px 16px; border:2px solid var(--gray-200); border-radius:var(--radius-lg); font-size:1rem; background:var(--bg); color:var(--text); cursor:pointer; transition:var(--transition-normal);">
        <?php foreach($doctors as $d): ?>
            <option value="<?= $d['id'] ?>" <?= ($d['id']==($_GET['doc']??1))?'selected':'' ?>>
                👨‍⚕️ <?= $d['name'] ?> — <?= $d['specialization'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Calendar Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="ri-calendar-2-line"></i>
            📅 <?= __('dash.this_week') ?>
        </div>
    </div>
    
    <!-- Week Navigation -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <a href="/dental-app4/public/?week=<?= $weekOffset - 1 ?>&doc=<?= $_GET['doc']??1 ?>" class="btn btn-secondary btn-sm">
            <i class="ri-arrow-left-s-line"></i>
            <?= __('dash.prev_week') ?>
        </a>
        
        <h3 style="margin:0; font-size:1.1rem; font-weight:700; color:var(--text); text-align:center; flex:1;">
            <?php if(!empty($days)): ?>
                <?= $days[0]['display'] ?> — <?= end($days)['display'] ?>
            <?php else: ?>
                <span style="color:var(--text-muted);"><?= __('common.loading') ?></span>
            <?php endif; ?>
        </h3>
        
        <a href="/dental-app4/public/?week=<?= $weekOffset + 1 ?>&doc=<?= $_GET['doc']??1 ?>" class="btn btn-secondary btn-sm">
            <?= __('dash.next_week') ?>
            <i class="ri-arrow-right-s-line"></i>
        </a>
    </div>

    <!-- Calendar Grid -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:16px;">
        <?php if(!empty($days)): ?>
            <?php foreach($days as $index => $day): ?>
                <div class="day-card" 
                     style="background:var(--bg); border:2px solid var(--gray-200); border-radius:var(--radius-lg); padding:20px; text-align:center; cursor:pointer; transition:var(--transition-normal); animation: fadeIn 0.5s ease <?= $index * 0.05 ?>s both;"
                     onclick="openSlotModal('<?= $day['date'] ?>', '<?= $day['display'] ?>')"
                     onmouseover="this.style.borderColor='var(--primary-500)'; this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(79,70,229,0.15)';"
                     onmouseout="this.style.borderColor='var(--gray-200)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <div style="font-size:2.5rem; font-weight:900; background:linear-gradient(135deg,var(--primary-500),var(--secondary-500)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:8px;">
                        <?= explode(' ', $day['display'])[0] ?>
                    </div>
                    <div style="font-size:0.9rem; color:var(--text-muted); margin-bottom:12px; font-weight:500;">
                        <?php 
                            $parts = explode(' ', $day['display']);
                            echo ($parts[1] ?? '') . ' ' . end($parts);
                        ?>
                    </div>
                    <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:linear-gradient(135deg,var(--primary-500),var(--secondary-500)); color:white; border-radius:20px; font-size:0.8rem; font-weight:600;">
                        <i class="ri-add-line"></i>
                        <?= __('dash.book_now') ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align:center; padding:60px; color:var(--text-muted);">
                <div class="spinner" style="margin:0 auto 20px;"></div>
                <p><?= __('common.loading') ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- My Appointments Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="ri-calendar-check-line"></i>
            <?= __('dash.my_appointments') ?>
        </div>
        <?php if(!empty($myAppointments)): ?>
            <span class="badge badge-success">
                <i class="ri-checkbox-circle-fill"></i>
                <?= $activeAppointments ?> <?= __('dash.active') ?>
            </span>
        <?php endif; ?>
    </div>
    
    <?php if(!empty($myAppointments)): ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--gray-50); border-bottom:2px solid var(--gray-200);">
                        <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;"><?= __('dash.date') ?></th>
                        <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;"><?= __('dash.time') ?></th>
                        <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;"><?= __('dash.doctor') ?></th>
                        <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;"><?= __('dash.status') ?></th>
                        <th style="padding:14px 16px; text-align:right; font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;"><?= __('dash.action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myAppointments as $index => $a): ?>
                        <tr style="border-bottom:1px solid var(--gray-100); transition:var(--transition-fast);" 
                            onmouseover="this.style.background='var(--gray-50)'" 
                            onmouseout="this.style.background='transparent'">
                            <td style="padding:16px;">
                                <div style="font-weight:600; color:var(--text);">
                                    <?= date('d', strtotime($a['appointment_date'])) ?>
                                    <span style="color:var(--text-muted); font-weight:400;">
                                        <?php 
                                            $monthKey = date('M', strtotime($a['appointment_date']));
                                            $translatedMonth = __('months')[$monthKey] ?? $monthKey;
                                        ?>
                                        <?= $translatedMonth ?> <?= date('Y', strtotime($a['appointment_date'])) ?>
                                    </span>
                                </div>
                            </td>
                            <td style="padding:16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i class="ri-time-line" style="color:var(--primary-500);"></i>
                                    <span style="font-weight:500;"><?= substr($a['start_time'], 0, 5) ?></span>
                                </div>
                            </td>
                            <td style="padding:16px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--primary-500),var(--secondary-500)); display:flex; align-items:center; justify-content:center; color:white; font-weight:600; font-size:0.9rem;">
                                        <?= strtoupper(substr($a['doctor_name'] ?? $a['doc_name'] ?? 'D', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight:600; color:var(--text);">
                                            <?= $a['doctor_name'] ?? $a['doc_name'] ?? 'Doktor' ?>
                                        </div>
                                        <div style="font-size:0.8rem; color:var(--text-muted);">
                                            <?= $a['specialization'] ?? 'Diş Hekimi' ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:16px;">
                                <?php 
                                    $isActive = $a['status'] !== 'cancelled';
                                    $badgeClass = $isActive ? 'badge-success' : 'badge-danger';
                                    $statusText = $isActive ? (__('dash.active') ?? 'Aktif') : (__('dash.cancelled') ?? 'İptal');
                                    $icon = $isActive ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill';
                                ?>
                                    <i class="<?= $icon ?>"></i>
                                    <?= $statusText ?>
                                </span>
                                <?php if($isActive): ?>
                                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px; display:flex; align-items:center; gap:4px;">
                                        <i class="ri-mail-check-line" style="color:var(--primary-500);"></i>
                                        <?= __('dash.mail_sent') ?? 'Bilgilendirme maili gönderildi' ?>
                                    </div>
                                <?php endif; ?>
                                </span>
                            </td>
                            <td style="padding:16px; text-align:right;">
                                <?php if($a['status'] !== 'cancelled'): ?>
                                    <button class="btn btn-danger btn-sm" onclick="cancelAppt(<?= $a['id'] ?>)">
                                        <i class="ri-close-circle-line"></i>
                                        <?= __('dash.cancel') ?>
                                    </button>
                                <?php else: ?>
                                    <span style="color:var(--text-muted); font-size:0.85rem;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div style="text-align:center; padding:80px 20px;">
            <div style="width:100px; height:100px; margin:0 auto 24px; background:linear-gradient(135deg,var(--gray-100),var(--gray-200)); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="ri-calendar-2-line" style="font-size:3rem; color:var(--gray-400);"></i>
            </div>
            <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:8px; color:var(--text);">
                <?= __('dash.no_appointments') ?>
            </h3>
            <p style="color:var(--text-muted); margin-bottom:24px; max-width:400px; margin-left:auto; margin-right:auto;">
                <?= __('dash.no_appointments_text') ?>
            </p>
            <button class="btn btn-primary" onclick="document.querySelector('.day-card')?.click();">
                <i class="ri-add-line"></i>
                <?= __('dash.book_appointment') ?>
            </button>
        </div>
    <?php endif; ?>
</div>

<!-- Slot Selection Modal -->
<div id="slot-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box" style="max-width:500px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h3 style="font-size:1.25rem; font-weight:700; display:flex; align-items:center; gap:10px;">
                <i class="ri-calendar-event-fill" style="color:var(--primary-500);"></i>
                <span id="modal-date-display"><?= __('modal.select_time') ?></span>
            </h3>
            <button onclick="closeModal()" style="background:var(--gray-100); border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:var(--transition-fast);" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                <i class="ri-close-line" style="font-size:1.25rem; color:var(--text);"></i>
            </button>
        </div>
        
        <div id="slots-loader" style="display:none; text-align:center; padding:40px;">
            <div class="spinner" style="margin:0 auto 16px;"></div>
            <p style="color:var(--text-muted);"><?= __('modal.loading') ?? 'Yükleniyor...' ?></p>
        </div>
        
        <div id="slots-container" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(100px, 1fr)); gap:12px;"></div>
        
        <input type="hidden" id="selected-date">
    </div>
</div>

<script>
function updateCalendar() {
    const docId = document.getElementById('doctor-select').value;
    window.location.href = '/dental-app4/public/?doc=' + docId;
}

function openSlotModal(date, display) {
    const modal = document.getElementById('slot-modal');
    const loader = document.getElementById('slots-loader');
    const container = document.getElementById('slots-container');
    const dateDisplay = document.getElementById('modal-date-display');
    const box = modal.querySelector('.modal-box');
    
    document.getElementById('selected-date').value = date;
    dateDisplay.textContent = display;
    modal.style.display = 'flex';
    loader.style.display = 'block';
    container.innerHTML = '';
    
    // Animate only this modal's box
    if (typeof gsap !== 'undefined') {
        gsap.fromTo(box, { scale: 0.8, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out' });
    }
    
    // Fetch slots
    const docId = document.getElementById('doctor-select').value;
    fetch(`/dental-app4/public/api/slots?date=${date}&doctor_id=${docId}`, {
        credentials: 'same-origin'
    })
        .then(r => r.json())
        .then(takenSlots => {
            loader.style.display = 'none';
            const allSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
            
            container.innerHTML = allSlots.map((slot, i) => {
                const isTaken = Array.isArray(takenSlots) && takenSlots.includes(slot);
                const btnClass = isTaken ? 'btn btn-secondary' : 'btn btn-primary';
                return `<button class="${btnClass}" style="padding:16px; font-size:1rem; animation: fadeIn 0.3s ease ${i * 0.05}s both;" 
                    ${isTaken ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : `onclick="bookSlot('${slot}')"`}>
                    <i class="ri-time-line"></i>
                    ${slot}
                </button>`;
            }).join('');
        })
        .catch(err => {
            loader.style.display = 'none';
            console.error('Slots API error:', err);
            container.innerHTML = '<p style="grid-column:1/-1; text-align:center; color:var(--danger-500); padding:20px;"><i class="ri-error-warning-line" style="font-size:2rem;"></i><br>Saatler yüklenemedi</p>';
        });
}

function closeModal() {
    const modal = document.getElementById('slot-modal');
    const box = modal.querySelector('.modal-box');
    
    if (typeof gsap !== 'undefined') {
        gsap.to(box, { 
            scale: 0.8, 
            opacity: 0, 
            duration: 0.2, 
            onComplete: () => {
                modal.style.display = 'none';
                gsap.set(box, { scale: 1, opacity: 1 });
            }
        });
    } else {
        modal.style.display = 'none';
    }
}

function bookSlot(time) {
    const date = document.getElementById('selected-date').value;
    const docId = document.getElementById('doctor-select').value;
    
    showConfirm('<?= __('confirm.book_text') ?? 'Bu randevuyu onaylıyor musunuz?' ?>', function() {
        fetch('/dental-app4/public/api/book', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            credentials: 'same-origin',
            body: JSON.stringify({doctor_id: docId, date: date, time: time})
        })
        .then(r => r.json())
        .then(data => {
            if(data.status === 'success') {
                showToast('<?= __('messages.booking_success') ?? 'Randevunuz başarıyla oluşturuldu!' ?>', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(data.message || '<?= __('messages.booking_error') ?? 'Randevu oluşturulamadı' ?>', 'error');
            }
        })
        .catch(err => {
            console.error('Book API error:', err);
            showToast('<?= __('messages.network_error') ?? 'Bağlantı hatası' ?>', 'error');
        });
    });
}

function cancelAppt(id) {
    showConfirm('<?= __('confirm.cancel_text') ?? 'Bu randevuyu iptal etmek istediğinize emin misiniz?' ?>', function() {
        fetch('/dental-app4/public/api/cancel', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            credentials: 'same-origin',
            body: JSON.stringify({id: id})
        })
        .then(r => r.json())
        .then(data => {
            if(data.status === 'success') {
                showToast('<?= __('messages.cancel_success') ?? 'Randevunuz iptal edildi.' ?>', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(data.message || '<?= __('messages.cancel_error') ?? 'İptal işlemi başarısız' ?>', 'error');
            }
        })
        .catch(err => {
            console.error('Cancel API error:', err);
            showToast('<?= __('messages.network_error') ?? 'Bağlantı hatası' ?>', 'error');
        });
    });
}

// Close modal on outside click
document.getElementById('slot-modal').addEventListener('click', function(e) {
    if(e.target === this) closeModal();
});
</script>