-- database/seed.sql
USE task_flow;

-- مستخدمون تجريبيون (كلمة المرور: password)
INSERT INTO users (name, email, password, role) VALUES
('أحمد محمد', 'ahmed@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('سارة علي', 'sara@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- تصنيفات
INSERT INTO categories (name, color) VALUES
('عمل', '#3498db'),
('شخصي', '#e74c3c'),
('دراسة', '#9b59b6');

-- مهام
INSERT INTO tasks (user_id, title, description, status, priority, due_date) VALUES
(1, 'إكمال مشروع PHP', 'إنهاء الأسبوع السادس من دورة التطوير', 'in_progress', 'high', '2026-09-15'),
(2, 'قراءة كتاب', 'قراءة فصل عن البرمجة', 'pending', 'medium', '2026-09-20');

-- ربط المهام بالتصنيفات
INSERT INTO task_category (task_id, category_id) VALUES (1, 1), (2, 3);