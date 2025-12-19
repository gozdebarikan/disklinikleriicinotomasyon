<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'tr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('register_title') ?> - DentalApp</title>
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
            max-width: 500px;
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
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }
        
        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }
        
        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 44px;
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
            left: 14px;
            bottom: 16px;
            color: var(--gray-500);
            font-size: 1.1rem;
        }
        
        .input-group.no-label i {
            top: 50%;
            transform: translateY(-50%);
            bottom: auto;
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
            margin-top: 8px;
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
        
        .password-hint {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 4px;
        }
        
        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .auth-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i class="ri-tooth-fill"></i>
            <h1>Dental<span>App</span></h1>
        </div>
        
        <p class="auth-subtitle">Yeni bir hesap oluşturun</p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-error">
                <i class="ri-error-warning-fill"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success">
                <i class="ri-checkbox-circle-fill"></i>
                <?= $success ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?? '' ?>">
            
            <div class="form-row">
                <div class="input-group">
                    <label>Ad</label>
                    <i class="ri-user-line"></i>
                    <input type="text" name="first_name" placeholder="Adınız" value="<?= $_POST['first_name'] ?? '' ?>" required>
                </div>
                
                <div class="input-group">
                    <label>Soyad</label>
                    <i class="ri-user-line"></i>
                    <input type="text" name="last_name" placeholder="Soyadınız" value="<?= $_POST['last_name'] ?? '' ?>" required>
                </div>
            </div>
            
            <div class="input-group">
                <label>TC Kimlik No</label>
                <i class="ri-id-card-line"></i>
                <input type="text" name="tc_no" placeholder="11 haneli TC Kimlik No" maxlength="11" pattern="[0-9]{11}" value="<?= $_POST['tc_no'] ?? '' ?>" required>
            </div>
            
            <div class="input-group">
                <label>Telefon</label>
                <i class="ri-phone-line"></i>
                <input type="tel" name="phone" placeholder="5XX XXX XX XX" pattern="[0-9]{10,11}" value="<?= $_POST['phone'] ?? '' ?>">
            </div>
            
            <div class="input-group">
                <label><?= __('email') ?></label>
                <i class="ri-mail-line"></i>
                <input type="email" name="email" placeholder="ornek@email.com" value="<?= $_POST['email'] ?? '' ?>" required>
            </div>
            
            <div class="input-group">
                <label><?= __('password') ?></label>
                <i class="ri-lock-password-line"></i>
                <input type="password" name="password" placeholder="En az 6 karakter" minlength="6" required>
                <p class="password-hint">Şifreniz en az 6 karakter olmalıdır.</p>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="ri-user-add-line"></i>
                <?= __('register_btn') ?>
            </button>
        </form>
        
        <div class="auth-footer">
            <?= __('have_account') ?? 'Zaten hesabınız var mı?' ?> 
            <a href="<?= url('/login') ?>"><?= __('login_btn') ?></a>
        </div>
    </div>
</body>
</html>