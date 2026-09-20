<div class="card">
    <h2 style="font-size: 1.5rem;">التصنيفات</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
        <?php foreach ($categories as $cat): ?>
        <div style="border: 1px solid var(--border); padding: 1.5rem; border-radius: var(--radius); border-right: 4px solid <?= $cat->color ?>; box-shadow: var(--shadow);">
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($cat->name) ?></h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">عدد المهام: <?= $cat->taskCount ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>