<div class="card" style="max-width: 400px; margin: 50px auto; box-shadow: var(--shadow-lg);">
    <h2 style="text-align: center; font-size: 1.5rem; margin-bottom: 1.5rem;">تسجيل الدخول</h2>
    <form action="/login" method="POST">
        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">دخول</button>
    </form>
</div>