<div class="auth-container">
    <div class="card auth-card">
        <h2 class="auth-title">إنشاء حساب جديد 🚀</h2>
        <p class="auth-subtitle">انضم إلينا وابدأ بإدارة مهامك باحترافية</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/register" method="POST">
            <?= \App\Security\CsrfToken::field() ?>
            <div class="form-group">
                <label>الاسم الكامل</label>
                <input type="text" name="name" class="form-control" placeholder="أدخل اسمك الكامل" required>
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="8 أحرف على الأقل" minlength="8" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">إنشاء الحساب</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
            لديك حساب بالفعل؟ <a href="/login" style="color: var(--primary); font-weight: 600; text-decoration: none;">تسجيل الدخول</a>
        </p>
    </div>
</div>