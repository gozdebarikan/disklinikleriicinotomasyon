<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'tr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('login_title') ?> - DentalApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --primary-500: #4f46e5;
            --primary-600: #4338ca;
            --secondary-500: #7c3aed;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --text: #1f2937;
            --danger: #ef4444;
            --success: #22c55e;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .auth-logo i {
            font-size: 3.5rem;
            color: var(--primary-500);
            display: block;
            margin-bottom: 12px;
        }
        
        .auth-logo h1 {
            font-size: 2rem;
            font-weight: 800;
        }
        
        .auth-logo h1 span { color: var(--primary-500); }
        
        .auth-subtitle {
            text-align: center;
            color: var(--gray-500);
            margin-bottom: 32px;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }
        
        .input-group input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 4px rgba(79,70,229,0.1);
        }
        
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.25rem;
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: inherit;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--secondary-500) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.5);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: var(--gray-500);
            font-size: 0.85rem;
        }
        
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }
        
        .divider span { padding: 0 16px; }
        
        .btn-edevlet {
            background: #c41e3a;
            color: white;
            margin-bottom: 16px;
        }
        
        .btn-edevlet:hover {
            background: #a01830;
            transform: translateY(-2px);
        }
        
        .btn-edevlet img {
            width: 24px;
            height: 24px;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            color: var(--gray-500);
            font-size: 0.9rem;
        }
        
        .auth-footer a {
            color: var(--primary-500);
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .demo-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
        
        .demo-info strong { display: block; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i class="ri-tooth-fill"></i>
            <h1>Dental<span>App</span></h1>
        </div>
        
        <p class="auth-subtitle">Hesabınıza giriş yapın</p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-error">
                <i class="ri-error-warning-fill"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <!-- Demo Info -->
        <div class="demo-info">
            <strong>🔑 Demo Hesap:</strong>
            E-posta: test@example.com | Şifre: 123456
        </div>
        
        <!-- e-Devlet Demo Button -->
        <button type="button" class="btn btn-edevlet" onclick="eDevletLogin()">
            <i class="ri-government-fill"></i>
            e-Devlet ile Giriş (Demo)
        </button>
        
        <div class="divider">
            <span>veya</span>
        </div>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?? '' ?>">
            
            <div class="input-group">
                <i class="ri-mail-line"></i>
                <input type="email" name="email" placeholder="<?= __('email') ?>" required>
            </div>
            
            <div class="input-group">
                <i class="ri-lock-password-line"></i>
                <input type="password" name="password" placeholder="<?= __('password') ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="ri-login-box-line"></i>
                <?= __('login_btn') ?>
            </button>
        </form>
        
        <div class="auth-footer">
            <?= __('no_account') ?? 'Hesabınız yok mu?' ?> 
            <a href="/dental-app4/public/register"><?= __('register_btn') ?></a>
        </div>
    </div>
    
    <script>
        function eDevletLogin() {
            // Demo e-Devlet girişi
            const btn = event.target.closest('.btn-edevlet');
            const originalContent = btn.innerHTML;
            
            btn.innerHTML = '<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i> e-Devlet\'e Bağlanılıyor...';
            btn.disabled = true;
            
            setTimeout(() => {
                alert('e-Devlet entegrasyonu şu an bakım modundadır. Lütfen e-posta ve şifre ile giriş yapınız.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }, 1000);
        }
    </script>
    
    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</body>
</html>