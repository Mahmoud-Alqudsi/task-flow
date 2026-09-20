<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">إنشاء مهمة جديدة</h2>
    <form action="/tasks/store" method="POST">
        <div class="form-group">
            <label>عنوان المهمة</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>الوصف</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>الأولوية</label>
            <select name="priority" class="form-control">
                <option value="low">منخفضة</option>
                <option value="medium" selected>متوسطة</option>
                <option value="high">عالية</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">حفظ المهمة</button>
    </form>
</div>