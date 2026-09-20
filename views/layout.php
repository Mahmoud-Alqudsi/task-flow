<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - نظام إدارة المهام</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- شريط التنقل يظهر فقط للمستخدمين المسجلين -->
    <nav class="navbar">
        <div class="container">
            <a href="/" class="brand">TaskFlow <span class="brand-icon">📋</span></a>
            <div class="nav-links">
                <a href="/tasks">المهام</a>
                <a href="/categories">التصنيفات</a>
                <a href="/dashboard">لوحة التحكم</a>
                
                <!-- نموذج تسجيل الخروج -->
                <form action="/logout" method="POST" style="display:inline;">
                    <?= \App\Security\CsrfToken::field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">خروج</button>
                </form>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <?php if (isset($_SESSION['user_id'])): ?>
    <footer class="footer">
        <p>تم البناء بكل حب في الأسبوع السادس &copy; 2026</p>
    </footer>
    <?php endif; ?>

</body>
</html>