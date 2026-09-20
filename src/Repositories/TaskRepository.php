<?php
namespace App\Repositories;

use App\Database;
use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use PDO;

class TaskRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * جلب جميع المهام (للاستخدام البسيط)
     */
    public function findAll(): array {
        $stmt = $this->db->query("
            SELECT tasks.*, users.name as user_name 
            FROM tasks 
            JOIN users ON tasks.user_id = users.id 
            ORDER BY tasks.created_at DESC
        ");
        
        return array_map([$this, 'hydrate'], $stmt->fetchAll());
    }

    /**
     * بحث متقدم مع فلاتر متعددة وترقيم صفحات
     * 
     * @param string|null $search كلمة البحث في العنوان والوصف
     * @param string|null $status فلترة بالحالة
     * @param string|null $priority فلترة بالأولوية
     * @param int|null $userId فلترة بالمستخدم (للمستخدم العادي)
     * @param int $page رقم الصفحة الحالية
     * @param int $perPage عدد العناصر في الصفحة
     * @return array ['tasks' => Task[], 'total' => int, 'pages' => int, 'current_page' => int]
     */
    public function advancedSearch(
        ?string $search = null,
        ?string $status = null,
        ?string $priority = null,
        ?int $userId = null,
        int $page = 1,
        int $perPage = 10,
    ): array {
        $conditions = [];
        $params = [];

        // فلتر البحث النصي (العنوان أو الوصف)
        if ($search !== null && trim($search) !== '') {
            $conditions[] = "(tasks.title LIKE :search OR tasks.description LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        // فلتر الحالة
        if ($status !== null && trim($status) !== '') {
            $conditions[] = "tasks.status = :status";
            $params['status'] = $status;
        }

        // فلتر الأولوية
        if ($priority !== null && trim($priority) !== '') {
            $conditions[] = "tasks.priority = :priority";
            $params['priority'] = $priority;
        }

        // فلتر المستخدم (لنظام الصلاحيات)
        if ($userId !== null) {
            $conditions[] = "tasks.user_id = :user_id";
            $params['user_id'] = $userId;
        }

        // بناء جملة WHERE
        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // حساب إجمالي النتائج
        $countSql = "SELECT COUNT(*) FROM tasks $where";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        // حساب الترقيم
        $pages = (int) ceil($total / $perPage);
        $page = max(1, min($page, max(1, $pages))); // ضمان أن الصفحة ضمن النطاق
        $offset = ($page - 1) * $perPage;

        // جلب المهام مع الترقيم
        $sql = "
            SELECT tasks.*, users.name as user_name 
            FROM tasks 
            JOIN users ON tasks.user_id = users.id 
            $where 
            ORDER BY tasks.created_at DESC 
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);
        
        // ربط المعاملات الديناميكية
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // ربط معاملات الترقيم كأعداد صحيحة (مهم لأداء PDO)
        $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $tasks = array_map([$this, 'hydrate'], $stmt->fetchAll());

        return [
            'tasks' => $tasks,
            'total' => $total,
            'pages' => $pages,
            'current_page' => $page,
        ];
    }

    /**
     * جلب إحصائيات المهام للوحة التحكم
     * 
     * @param int|null $userId إذا تم تمريره، تُحسب الإحصائيات لهذا المستخدم فقط
     * @return array الإحصائيات
     */
    public function getStatistics(?int $userId = null): array {
        $where = $userId !== null ? "WHERE user_id = :user_id" : '';
        $params = $userId !== null ? ['user_id' => $userId] : [];

        $sql = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN due_date < CURDATE() AND status NOT IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as overdue
            FROM tasks 
            $where
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $stats = $stmt->fetch();

        // تحويل القيم الفارغة إلى صفر (في حالة عدم وجود مهام)
        return array_map(fn($v) => (int) ($v ?? 0), $stats);
    }

    /**
     * تحويل صف قاعدة البيانات إلى كائن Task
     */
    private function hydrate(array $row): Task {
        return new Task(
            id: (int) $row['id'],
            userId: (int) $row['user_id'],
            title: $row['title'],
            description: $row['description'],
            status: TaskStatus::from($row['status']),
            priority: TaskPriority::from($row['priority']),
            dueDate: $row['due_date'],
            createdAt: $row['created_at'],
            userName: $row['user_name'] ?? ''
        );
    }
}