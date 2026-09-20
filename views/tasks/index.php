<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">إدارة المهام</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">متابعة وتنظيم جميع مهامك اليومية</p>
        </div>
        <a href="/tasks/create" class="btn btn-primary">+ مهمة جديدة</a>
    </div>
    
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>عنوان المهمة</th>
                    <th>الحالة</th>
                    <th>الأولوية</th>
                    <th>المسؤول</th>
                    <th style="text-align: left;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td style="font-weight: 600;"><?= htmlspecialchars($task->title) ?></td>
                    <td><span class="badge badge-info"><?= $task->status->label() ?></span></td>
                    <td><span class="badge badge-warning"><?= $task->priority->label() ?></span></td>
                    <td style="color: var(--text-muted);"><?= htmlspecialchars($task->userName) ?></td>
                    <td style="text-align: left;">
                        <a href="/tasks/<?= $task->id ?>/edit" class="btn btn-sm btn-primary">تعديل</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>