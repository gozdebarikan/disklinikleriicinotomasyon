/* ===================================
   DENTAL APP - MODERN JAVASCRIPT
   GSAP + Anime.js + Micro-interactions
   =================================== */

// ===================================
// THEME MANAGEMENT
// ===================================

const theme = localStorage.getItem('theme') || 'light';
setTheme(theme);

document.getElementById('theme-btn')?.addEventListener('click', () => {
    const cur = document.documentElement.getAttribute('data-theme');
    const next = cur === 'dark' ? 'light' : 'dark';
    setTheme(next);

    // Animate theme switch
    anime({
        targets: '#theme-icon',
        rotate: '1turn',
        duration: 600,
        easing: 'easeInOutQuad'
    });
});

function setTheme(mode) {
    document.documentElement.setAttribute('data-theme', mode);
    localStorage.setItem('theme', mode);

    const icon = document.getElementById('theme-icon');
    if (icon) {
        if (mode === 'light') {
            icon.className = 'ri-sun-line';
            icon.style.color = '#f59e0b';
        } else {
            icon.className = 'ri-moon-line';
            icon.style.color = '#9ca3af';
        }
    }
}

// ===================================
// CONFIRM MODAL (Enhanced)
// ===================================

const confirmModal = document.getElementById('confirm-modal');
const confirmBox = document.getElementById('confirm-box');
const confirmText = document.getElementById('confirm-text');
const confirmYesBtn = document.getElementById('confirm-yes-btn');
let confirmCallback = null;

function showConfirm(text, callback) {
    confirmText.innerText = text;
    confirmCallback = callback;
    confirmModal.style.display = 'flex';

    // Animate modal appearance with Anime.js
    anime({
        targets: '#confirm-box',
        scale: [0.8, 1],
        opacity: [0, 1],
        duration: 400,
        easing: 'easeOutElastic(1, .8)'
    });
}

function closeConfirm() {
    // Animate modal disappearance
    anime({
        targets: '#confirm-box',
        scale: 0.8,
        opacity: 0,
        duration: 200,
        easing: 'easeInQuad',
        complete: () => {
            confirmModal.style.display = 'none';
        }
    });
    confirmCallback = null;
}

confirmYesBtn?.addEventListener('click', () => {
    if (confirmCallback) confirmCallback();
    closeConfirm();
});

// ===================================
// BUTTON RIPPLE EFFECT
// ===================================

document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn');
    if (!btn) return;

    const ripple = document.createElement('span');
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        pointer-events: none;
        transform: translate(-50%, -50%) scale(0);
    `;

    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (e.clientX - rect.left) + 'px';
    ripple.style.top = (e.clientY - rect.top) + 'px';

    btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.appendChild(ripple);

    anime({
        targets: ripple,
        scale: 2,
        opacity: [0.6, 0],
        duration: 600,
        easing: 'easeOutQuad',
        complete: () => ripple.remove()
    });
});

// ===================================
// APPOINTMENT BOOKING
// ===================================

const modal = document.getElementById('slot-modal');
const slotsContainer = document.getElementById('slots-container');
const loader = document.getElementById('slots-loader');

function closeModal() {
    anime({
        targets: '.modal-box',
        opacity: [1, 0],
        scale: [1, 0.9],
        duration: 200,
        easing: 'easeInQuad',
        complete: () => {
            modal.style.display = 'none';
        }
    });
}

async function openSlotModal(date, display) {
    document.getElementById('modal-date-display').innerText = display;
    document.getElementById('selected-date').value = date;
    modal.style.display = 'flex';
    slotsContainer.innerHTML = '';
    loader.style.display = 'block';

    const docId = document.getElementById('doctor-select').value;

    // Animate modal appearance
    anime({
        targets: '.modal-box',
        opacity: [0, 1],
        scale: [0.9, 1],
        duration: 400,
        easing: 'easeOutElastic(1, .8)'
    });

    try {
        const res = await fetch(`/api/slots?date=${date}&doctor_id=${docId}`);
        const takenSlots = await res.json();
        loader.style.display = 'none';

        const allSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

        allSlots.forEach((time, index) => {
            const btn = document.createElement('button');
            btn.className = 'slot-btn';
            btn.innerText = time;
            btn.style.opacity = '0';
            btn.style.transform = 'translateY(10px)';

            const isTaken = takenSlots.includes(time + ':00') || takenSlots.includes(time);
            const slotDate = new Date(date + 'T' + time);

            if (isTaken || slotDate < new Date()) {
                btn.disabled = true;
                btn.style.opacity = '0.5';
            } else {
                btn.onclick = () => {
                    closeModal();
                    showConfirm('Seçilen saat için randevu oluşturulsun mu?', () => {
                        bookAppointment(date, time, docId);
                    });
                };
            }

            slotsContainer.appendChild(btn);

            // Staggered animation for slot buttons
            anime({
                targets: btn,
                opacity: isTaken ? 0.5 : 1,
                translateY: [10, 0],
                delay: index * 50,
                duration: 400,
                easing: 'easeOutQuad'
            });
        });
    } catch (e) {
        showToast('❌ Hata oluştu', 'error');
        closeModal();
    }
}

async function bookAppointment(date, time, docId) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const res = await fetch('/api/book', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ date, time, doctor_id: docId })
    });

    const json = await res.json();

    if (json.status === 'success') {
        // Success animation
        showToast('✅ Randevu oluşturuldu!', 'success');
        setTimeout(() => location.reload(), 1000);
    } else {
        showToast('❌ ' + json.message, 'error');
    }
}

async function cancelAppt(id) {
    showConfirm('Bu randevuyu iptal etmek istediğinize emin misiniz?', async () => {
        const res = await fetch('/api/cancel', {
            method: 'POST',
            body: JSON.stringify({ id })
        });
        const json = await res.json();

        if (json.status === 'success') {
            showToast('✅ Randevu iptal edildi', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast('❌ ' + json.message, 'error');
        }
    });
}

// ===================================
// TOAST NOTIFICATIONS (NEW)
// ===================================

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        z-index: 10000;
        font-weight: 600;
        transform: translateX(400px);
    `;

    document.body.appendChild(toast);

    // Slide in animation
    anime({
        targets: toast,
        translateX: [400, 0],
        duration: 400,
        easing: 'easeOutQuad'
    });

    // Auto remove after 3s
    setTimeout(() => {
        anime({
            targets: toast,
            translateX: 400,
            opacity: 0,
            duration: 300,
            easing: 'easeInQuad',
            complete: () => toast.remove()
        });
    }, 3000);
}

// ===================================
// HOVER ANIMATIONS FOR CARDS
// ===================================

document.querySelectorAll('.day-card').forEach(card => {
    card.addEventListener('mouseenter', function () {
        anime({
            targets: this,
            scale: 1.05,
            duration: 300,
            easing: 'easeOutQuad'
        });
    });

    card.addEventListener('mouseleave', function () {
        anime({
            targets: this,
            scale: 1,
            duration: 300,
            easing: 'easeOutQuad'
        });
    });
});

// ===================================
// NAV ITEM HOVER EFFECTS
// ===================================

document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('mouseenter', function () {
        anime({
            targets: this.querySelector('i'),
            rotateZ: [0, 10, -10, 0],
            duration: 500,
            easing: 'easeInOutQuad'
        });
    });
});

// ===================================
// SCROLL ANIMATIONS (GSAP)
// ===================================

gsap.registerPlugin(ScrollTrigger);

// Fade in elements on scroll
gsap.utils.toArray('.card').forEach((card, index) => {
    gsap.from(card, {
        scrollTrigger: {
            trigger: card,
            start: 'top 90%',
            toggleActions: 'play none none reverse'
        },
        opacity: 0,
        y: 50,
        duration: 0.6,
        delay: index * 0.1
    });
});

// ===================================
// FORM VALIDATION ANIMATIONS
// ===================================

document.querySelectorAll('input, select, textarea').forEach(input => {
    input.addEventListener('invalid', (e) => {
        e.preventDefault();
        anime({
            targets: input,
            translateX: [-10, 10, -10, 10, 0],
            duration: 400,
            easing: 'easeInOutQuad'
        });
        input.style.borderColor = '#ef4444';
    });

    input.addEventListener('input', () => {
        if (input.validity.valid) {
            input.style.borderColor = '#10b981';
        }
    });
});

// ===================================
// PERFORMANCE: Lazy load images
// ===================================

if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

console.log('🚀 Dental App - Modern UI Loaded!');