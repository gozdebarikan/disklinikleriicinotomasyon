<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'tr' ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modern Dental Clinic Appointment System - Professional Healthcare Management">
    <meta name="keywords" content="dental, appointment, clinic, healthcare, diş, randevu">
    <meta name="author" content="DentalApp">
    <meta name="theme-color" content="#4f46e5">
    
    <title><?= $pageTitle ?? 'DentalApp - ' . (__('menu.dashboard') ?? 'Dashboard') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🦷</text></svg>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-400: #818cf8;
            --primary-500: #4f46e5;
            --primary-600: #4338ca;
            --primary-700: #3730a3;
            --secondary-500: #7c3aed;
            --success-500: #22c55e;
            --warning-500: #f59e0b;
            --danger-500: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --text: #1f2937;
            --text-muted: #6b7280;
            --bg: #f9fafb;
            --bg-elevated: #ffffff;
            --sidebar-bg: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            --sidebar-text: #94a3b8;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --transition-fast: 0.15s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }
        
        [data-theme="dark"] {
            --text: #f9fafb;
            --text-muted: #9ca3af;
            --bg: #0f172a;
            --bg-elevated: #1e293b;
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            --gray-50: #334155;
            --gray-100: #1e293b;
            --gray-200: #334155;
            --gray-300: #475569;
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.3);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            background: var(--bg); 
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }
        
        .app-container { 
            display: flex; 
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar { 
            width: 280px; 
            min-width: 280px;
            background: var(--sidebar-bg); 
            padding: 24px;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 100;
            box-shadow: var(--shadow-xl);
        }
        
        .content { 
            flex: 1; 
            padding: 32px;
            margin-left: 280px;
            width: calc(100% - 280px);
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .brand { 
            font-size: 1.75rem; 
            font-weight: 900; 
            color: white; 
            text-decoration: none; 
            display: flex; 
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            transition: var(--transition-normal);
        }
        
        .brand:hover { transform: scale(1.02); }
        
        .brand i { 
            color: var(--primary-400); 
            font-size: 2rem;
            animation: bounce 2s infinite;
        }
        
        .brand-text span { color: var(--primary-400); }
        
        .nav-section { flex: 1; }
        
        .nav-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-500);
            padding: 0 16px;
            margin-bottom: 8px;
            margin-top: 24px;
        }
        
        .nav-item { 
            display: flex; 
            align-items: center;
            gap: 12px;
            padding: 14px 16px; 
            color: var(--sidebar-text); 
            text-decoration: none; 
            border-radius: var(--radius-lg); 
            margin-bottom: 4px;
            transition: var(--transition-normal);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-500);
            transform: scaleY(0);
            transition: var(--transition-fast);
        }
        
        .nav-item:hover { 
            background: rgba(255,255,255,0.08); 
            color: white;
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }
        
        .nav-item.active::before { transform: scaleY(1); }
        
        .nav-item i { font-size: 1.25rem; }
        
        .nav-badge {
            margin-left: auto;
            background: var(--danger-500);
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .nav-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 20px;
        }
        
        .user-card {
            background: rgba(255,255,255,0.05);
            border-radius: var(--radius-lg);
            padding: 16px;
            margin-bottom: 16px;
            transition: var(--transition-normal);
        }
        
        .user-card:hover {
            background: rgba(255,255,255,0.08);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(79,70,229,0.3);
        }
        
        .user-details h4 {
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .user-details span {
            font-size: 0.75rem;
            color: var(--sidebar-text);
        }
        
        .settings-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }
        
        .icon-btn {
            background: rgba(255,255,255,0.05);
            border: none;
            color: var(--sidebar-text);
            cursor: pointer;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            transition: var(--transition-normal);
            font-size: 0.85rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .icon-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateY(-2px);
        }
        
        .icon-btn i { font-size: 1.1rem; }
        
        /* Cards */
        .card {
            background: var(--bg-elevated);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 24px;
            border: 1px solid var(--gray-100);
            transition: var(--transition-normal);
            animation: fadeIn 0.5s ease;
        }
        
        .card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-2px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-title i { color: var(--primary-500); }
        
        .page-header {
            margin-bottom: 32px;
            animation: slideInLeft 0.6s ease;
        }
        
        .page-header h1 {
            font-size: 2.25rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .page-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }
        
        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: var(--radius-md);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-normal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
            text-decoration: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79,70,229,0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
        }
        
        .btn-secondary {
            background: var(--gray-100);
            color: var(--text);
        }
        
        .btn-secondary:hover {
            background: var(--gray-200);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-500) 0%, #dc2626 100%);
            color: white;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        
        /* Status Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .badge-success {
            background: rgba(34,197,94,0.15);
            color: var(--success-500);
        }
        
        .badge-danger {
            background: rgba(239,68,68,0.15);
            color: var(--danger-500);
        }
        
        .badge-warning {
            background: rgba(245,158,11,0.15);
            color: var(--warning-500);
        }
        
        /* Confirm Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(8px);
            animation: fadeIn 0.2s ease;
        }
        
        .modal-box {
            background: var(--bg-elevated);
            padding: 32px;
            border-radius: var(--radius-xl);
            width: 400px;
            max-width: 90%;
            text-align: center;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.3s ease;
        }
        
        .modal-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }
        
        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
                width: 100%;
                padding: 16px;
            }
            
            .mobile-menu-btn {
                display: flex !important;
            }
            
            .page-header h1 {
                font-size: 1.75rem;
            }
        }
        
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1001;
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            color: white;
            border: none;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
            transition: var(--transition-normal);
        }
        
        .mobile-menu-btn:hover { transform: scale(1.1); }
        
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 99;
            backdrop-filter: blur(4px);
        }
        
        .mobile-overlay.open { display: block; }
        
        /* Tooltip */
        .tooltip {
            position: relative;
        }
        
        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-fast);
        }
        
        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
        }
        
        /* Loading Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--gray-200);
            border-top-color: var(--primary-500);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: var(--bg-elevated);
            border-radius: var(--radius-lg);
            padding: 20px;
            border: 1px solid var(--gray-100);
            transition: var(--transition-normal);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 12px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .toast {
            background: var(--bg-elevated);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            box-shadow: var(--shadow-xl);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .toast-success { border-left: 4px solid var(--success-500); }
        .toast-error { border-left: 4px solid var(--danger-500); }
        .toast-warning { border-left: 4px solid var(--warning-500); }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <i class="ri-menu-line" style="font-size:1.5rem;"></i>
    </button>
    
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>
    
    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>
    
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="/dental-app4/public/" class="brand">
                <i class="ri-tooth-fill"></i>
                <span class="brand-text">Dental<span>App</span></span>
            </a>
            
            <nav class="nav-section">
                <div class="nav-label"><?= __('menu.dashboard') ?? 'MENU' ?></div>
                <?php $currentUri = $_SERVER['REQUEST_URI']; ?>
                <a href="/dental-app4/public/" class="nav-item <?= strpos($currentUri, '/profile') === false ? 'active' : '' ?>">
                    <i class="ri-calendar-event-fill"></i>
                    <span><?= __('menu.dashboard') ?></span>
                </a>
                <a href="/dental-app4/public/profile" class="nav-item <?= strpos($currentUri, '/profile') !== false ? 'active' : '' ?>">
                    <i class="ri-user-settings-fill"></i>
                    <span><?= __('menu.profile') ?></span>
                </a>
            </nav>
            
            <div class="nav-bottom">
                <div class="user-card">
                    <div class="user-info">
                        <div class="user-avatar">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="user-details">
                            <h4><?= $_SESSION['user_name'] ?? 'User' ?></h4>
                            <span><?php 
                                $role = $_SESSION['user_role'] ?? 'patient';
                                $roleTranslations = [
                                    'patient' => __('common.patient') ?? ($_SESSION['lang'] === 'tr' ? 'Hasta' : 'Patient'),
                                    'admin' => __('common.admin') ?? ($_SESSION['lang'] === 'tr' ? 'Yönetici' : 'Admin'),
                                    'doctor' => __('common.doctor') ?? ($_SESSION['lang'] === 'tr' ? 'Doktor' : 'Doctor')
                                ];
                                echo ucfirst($roleTranslations[$role] ?? $role);
                            ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="settings-row">
                    <?php 
                        $curLang = $_SESSION['lang'] ?? 'tr';
                        $targetLang = ($curLang == 'tr') ? 'en' : 'tr';
                        $langLabel = ($curLang == 'tr') ? '🇬🇧 English' : '🇹🇷 Türkçe';
                    ?>
                    <a href="/dental-app4/public/lang?l=<?= $targetLang ?>" class="icon-btn tooltip" data-tooltip="<?= $langLabel ?>">
                        <?= ($curLang == 'tr') ? '🇬🇧' : '🇹🇷' ?>
                        <span><?= ($curLang == 'tr') ? 'EN' : 'TR' ?></span>
                    </a>
                    
                    <button class="icon-btn tooltip" onclick="toggleTheme()" data-tooltip="Tema Değiştir">
                        <i class="ri-sun-line" id="theme-icon"></i>
                    </button>
                    
                    <a href="/dental-app4/public/logout" class="icon-btn tooltip" data-tooltip="<?= __('menu.logout') ?>" style="color:var(--danger-500);">
                        <i class="ri-logout-box-r-line"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <?php if (isset($childView) && file_exists($childView)) include $childView; ?>
        </main>
    </div>

    <!-- Confirm Modal -->
    <div id="confirm-modal" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="ri-question-line"></i>
            </div>
            <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:8px;"><?= __('confirm.title') ?></h3>
            <p id="confirm-text" style="color:var(--text-muted); margin-bottom:24px;">...</p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button class="btn btn-secondary" onclick="closeConfirm()">
                    <i class="ri-close-line"></i> <?= __('confirm.no') ?>
                </button>
                <button class="btn btn-primary" id="confirm-yes-btn">
                    <i class="ri-check-line"></i> <?= __('confirm.yes') ?>
                </button>
            </div>
        </div>
    </div>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js"></script>
    
    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            
            if (html.getAttribute('data-theme') === 'dark') {
                html.setAttribute('data-theme', 'light');
                icon.className = 'ri-sun-line';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                icon.className = 'ri-moon-line';
                localStorage.setItem('theme', 'dark');
            }
            
            // Animate icon
            gsap.from(icon, { rotation: 360, duration: 0.5, ease: 'back.out' });
        }
        
        // Load saved theme
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            const icon = document.getElementById('theme-icon');
            if (icon) {
                icon.className = savedTheme === 'dark' ? 'ri-moon-line' : 'ri-sun-line';
            }
        })();
        
        // Mobile Menu
        function toggleMobileMenu() {
            document.getElementById('sidebar').classList.toggle('open');
            document.querySelector('.mobile-overlay').classList.toggle('open');
        }
        
        // Toast Notifications
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast toast-' + type;
            toast.innerHTML = `
                <i class="ri-${type === 'success' ? 'checkbox-circle' : type === 'error' ? 'error-warning' : 'alert'}-fill" style="font-size:1.5rem; color:var(--${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'warning'}-500);"></i>
                <span>${message}</span>
            `;
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
        
        // Confirm Modal
        let confirmCallback = null;
        
        function showConfirm(text, callback) {
            const modal = document.getElementById('confirm-modal');
            const box = modal.querySelector('.modal-box');
            document.getElementById('confirm-text').textContent = text;
            modal.style.display = 'flex';
            confirmCallback = callback;
            
            if (typeof gsap !== 'undefined') {
                gsap.fromTo(box, { scale: 0.8, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out' });
            }
        }
        
        function closeConfirm() {
            const modal = document.getElementById('confirm-modal');
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
        
        document.getElementById('confirm-yes-btn').addEventListener('click', function() {
            closeConfirm();
            if (confirmCallback) confirmCallback();
        });
        
        // Page Load Animations - Using CSS animations instead of GSAP for reliability
        // GSAP is only used for interactive elements like modals
    </script>
</body>
</html>