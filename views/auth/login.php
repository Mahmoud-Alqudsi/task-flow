<div class="auth-container">
    <div class="card auth-card">
        <h2 class="auth-title">مرحباً بعودتك 👋</h2>
        <p class="auth-subtitle">سجل دخولك للوصول إلى مهامك</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="/login" method="POST">
            <?= \App\Security\CsrfToken::field() ?>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">تسجيل الدخول</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
            ليس لديك حساب؟ <a href="/register" style="color: var(--primary); font-weight: 600; text-decoration: none;">إنشاء حساب جديد</a>
        </p>
    </div>
</div>