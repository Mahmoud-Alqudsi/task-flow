<div class="card" style="max-width: 400px; margin: 50px auto; box-shadow: var(--shadow-lg);">
    <h2 style="text-align: center; font-size: 1.5rem; margin-bottom: 1.5rem;">إنشاء حساب جديد</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/register" method="POST">
        <?= \App\Security\CsrfToken::field() ?>
        <div class="form-group">
            <label>الاسم الكامل</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>كلمة المرور (8 أحرف على الأقل)</label>
            <input type="password" name="password" class="form-control" minlength="8" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">تسجيل</button>
        <p style="text-align: center; margin-top: 15px; color: var(--text-muted);">
            لديك حساب بالفعل؟ <a href="/login" style="color: var(--primary);">سجل الدخول</a>
        </p>
    </form>
</div>