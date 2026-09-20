<div class="card">
    <!-- رأس الصفحة -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">إدارة المهام</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                <?= $isAdmin ? 'عرض جميع مهام النظام (وضع المدير)' : 'مهامك الشخصية' ?>
                • إجمالي النتائج: <strong><?= $total ?></strong>
            </p>
        </div>
        <a href="/tasks/create" class="btn btn-primary">+ مهمة جديدة</a>
    </div>

    <!-- نموذج البحث المتقدم -->
    <div style="background: #f8fafc; padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border); margin-bottom: 1.5rem;">
        <form method="GET" action="/tasks" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 0.85rem;">بحث نصي</label>
                <input type="text" name="search" class="form-control" 
                       value="<?= htmlspecialchars($filters['search'] ?? '') ?>" 
                       placeholder="ابحث في العنوان أو الوصف...">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 0.85rem;">الحالة</label>
                <select name="status" class="form-control">
                    <option value="">الكل</option>
                    <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>قيد الانتظار</option>
                    <option value="in_progress" <?= ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>جاري التنفيذ</option>
                    <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>مكتملة</option>
                    <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>ملغية</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 0.85rem;">الأولوية</label>
                <select name="priority" class="form-control">
                    <option value="">الكل</option>
                    <option value="low" <?= ($filters['priority'] ?? '') === 'low' ? 'selected' : '' ?>>منخفضة</option>
                    <option value="medium" <?= ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' ?>>متوسطة</option>
                    <option value="high" <?= ($filters['priority'] ?? '') === 'high' ? 'selected' : '' ?>>عالية</option>
                    <option value="urgent" <?= ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' ?>>عاجلة</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">تطبيق</button>
                <a href="/tasks" class="btn btn-danger">مسح</a>
            </div>
        </form>
    </div>

    <!-- جدول المهام -->
    <?php if (empty($tasks)): ?>
        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
            <p style="font-size: 3rem; margin-bottom: 1rem;">📭</p>
            <p style="font-size: 1.1rem; font-weight: 600;">لا توجد مهام مطابقة لبحثك</p>
            <p style="font-size: 0.9rem;">جرّب تعديل الفلاتر أو البحث بكلمات مختلفة</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>عنوان المهمة</th>
                        <th>الحالة</th>
                        <th>الأولوية</th>
                        <?php if ($isAdmin): ?>
                            <th>المسؤول</th>
                        <?php endif; ?>
                        <th style="text-align: left;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($task->title) ?></td>
                        <td>
                            <?php 
                            $statusClass = match($task->status->value) {
                                'completed' => 'badge-success',
                                'in_progress' => 'badge-info',
                                'cancelled' => 'badge-danger',
                                default => 'badge-warning',
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $task->status->label() ?></span>
                        </td>
                        <td><span class="badge badge-warning"><?= $task->priority->label() ?></span></td>
                        <?php if ($isAdmin): ?>
                            <td style="color: var(--text-muted);"><?= htmlspecialchars($task->userName) ?></td>
                        <?php endif; ?>
                        <td style="text-align: left;">
                            <a href="/tasks/<?= $task->id ?>/edit" class="btn btn-sm btn-primary">تعديل</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- ترقيم الصفحات -->
        <?php if ($pages > 1): ?>
            <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 1.5rem;">
                <?php if ($currentPage > 1): ?>
                    <a href="<?= $this->paginationUrl($currentPage - 1) ?>" class="btn btn-sm btn-primary">السابق</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i === $currentPage): ?>
                        <span class="btn btn-sm btn-primary" style="opacity: 0.7; cursor: default;"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= $this->paginationUrl($i) ?>" class="btn btn-sm" style="background: #f1f5f9; color: var(--text-main);"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $pages): ?>
                    <a href="<?= $this->paginationUrl($currentPage + 1) ?>" class="btn btn-sm btn-primary">التالي</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>