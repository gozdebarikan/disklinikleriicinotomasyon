<?php

$user = $user ?? [];
$first_name = $user['first_name'] ?? explode(' ', $_SESSION['user_name'] ?? 'User')[0];
$last_name = $user['last_name'] ?? (explode(' ', $_SESSION['user_name'] ?? 'User Name')[1] ?? '');
$email = $user['email'] ?? $_SESSION['user_email'] ?? '';
$langCode = $_SESSION['lang'] ?? 'tr';
?>

<div class="page-header">
    <h1><?= __('profile.title') ?></h1>
    <p style="color:var(--text-muted);"><?= __('profile.personal_info') ?? ($langCode === 'tr' ? 'Kişisel bilgilerinizi güncelleyebilirsiniz.' : 'You can update your personal information.') ?></p>
</div>

<div style="display:flex; justify-content:center;">
    <div class="card" style="width:100%; max-width:500px;">
        <?php if(isset($success) && $success): ?>
            <div style="background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                <i class="ri-checkbox-circle-fill"></i>
                <?= __('profile.success') ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error) && $error): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                <i class="ri-error-warning-fill"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text);">
                    <i class="ri-user-line"></i> <?= __('profile.first_name') ?? ($langCode === 'tr' ? 'Ad' : 'First Name') ?>
                </label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required
                    style="width:100%; padding:12px; border:1px solid var(--gray-200); border-radius:8px; font-size:1rem; background:var(--bg); color:var(--text);">
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text);">
                    <i class="ri-user-line"></i> <?= __('profile.last_name') ?? ($langCode === 'tr' ? 'Soyad' : 'Last Name') ?>
                </label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required
                    style="width:100%; padding:12px; border:1px solid var(--gray-200); border-radius:8px; font-size:1rem; background:var(--bg); color:var(--text);">
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text);">
                    <i class="ri-mail-line"></i> <?= $langCode === 'tr' ? 'E-posta' : 'Email' ?>
                </label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required
                    style="width:100%; padding:12px; border:1px solid var(--gray-200); border-radius:8px; font-size:1rem; background:var(--bg); color:var(--text);">
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text);">
                    <i class="ri-lock-password-line"></i> <?= __('profile.new_password') ?? ($langCode === 'tr' ? 'Yeni Şifre' : 'New Password') ?>
                </label>
                <input type="password" name="password" placeholder="<?= __('profile.pass_hint') ?? ($langCode === 'tr' ? 'Değiştirmek istemiyorsanız boş bırakın' : 'Leave blank to keep current password') ?>"
                    style="width:100%; padding:12px; border:1px solid var(--gray-200); border-radius:8px; font-size:1rem; background:var(--bg); color:var(--text);">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1rem; justify-content:center;">
                <i class="ri-save-line"></i> <?= __('profile.update') ?>
            </button>
        </form>
    </div>
</div>