<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 1.5rem;">قائمة المهام</h2>
        <a href="/tasks/create" class="btn btn-primary">+ مهمة جديدة</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الحالة</th>
                <th>الأولوية</th>
                <th>المسؤول</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td style="font-weight: 500;"><?= htmlspecialchars($task->title) ?></td>
                <td><span class="badge badge-info"><?= $task->status->label() ?></span></td>
                <td><span class="badge badge-warning"><?= $task->priority->label() ?></span></td>
                <td><?= htmlspecialchars($task->userName) ?></td>
                <td>
                    <a href="/tasks/<?= $task->id ?>/edit" class="btn btn-sm btn-primary">تعديل</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>