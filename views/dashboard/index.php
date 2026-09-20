<div style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.75rem; font-weight: 700;">مرحباً، <?= htmlspecialchars($userName) ?> 👋</h2>
    <p style="color: var(--text-muted);">
        <?= $isAdmin ? 'نظرة عامة على إحصائيات النظام كاملة (وضع المدير)' : 'نظرة عامة على إحصائيات مهامك الشخصية' ?>
    </p>
</div>

<!-- بطاقات الإحصائيات -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="border-top: 4px solid var(--primary); text-align: center;">
        <h3 style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">إجمالي المهام</h3>
        <p style="font-size: 2.75rem; font-weight: 800; color: var(--primary); margin-top: 0.5rem;"><?= $stats['total'] ?></p>
    </div>
    
    <div class="card" style="border-top: 4px solid #22c55e; text-align: center;">
        <h3 style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">المكتملة</h3>
        <p style="font-size: 2.75rem; font-weight: 800; color: #22c55e; margin-top: 0.5rem;"><?= $stats['completed'] ?></p>
    </div>
    
    <div class="card" style="border-top: 4px solid #f59e0b; text-align: center;">
        <h3 style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">قيد الانتظار</h3>
        <p style="font-size: 2.75rem; font-weight: 800; color: #f59e0b; margin-top: 0.5rem;"><?= $stats['pending'] ?></p>
    </div>
    
    <div class="card" style="border-top: 4px solid #ef4444; text-align: center;">
        <h3 style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">متأخرة</h3>
        <p style="font-size: 2.75rem; font-weight: 800; color: #ef4444; margin-top: 0.5rem;"><?= $stats['overdue'] ?></p>
    </div>
</div>

<!-- نسبة الإنجاز -->
<div class="card">
    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">نسبة الإنجاز الكلية</h3>
    
    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
        <span style="color: var(--text-muted); font-size: 0.9rem;">التقدم المحرز</span>
        <span style="font-weight: 700; color: var(--primary);"><?= $completionRate ?>%</span>
    </div>
    
    <div style="background: #e2e8f0; border-radius: 9999px; height: 12px; overflow: hidden;">
        <div style="background: linear-gradient(90deg, var(--primary), #818cf8); height: 100%; width: <?= $completionRate ?>%; border-radius: 9999px; transition: width 0.5s ease;"></div>
    </div>
    
    <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
        <?= $stats['completed'] ?> من أصل <?= $stats['total'] ?> مهمة مكتملة
        <?php if ($stats['overdue'] > 0): ?>
            • <span style="color: #ef4444; font-weight: 600;">⚠️ لديك <?= $stats['overdue'] ?> مهمة متأخرة</span>
        <?php endif; ?>
    </p>
</div>