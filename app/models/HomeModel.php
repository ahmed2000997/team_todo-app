<?php

class HomeModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // 🔸 جلب أعضاء الفريق
    public function getTeamMembers($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT u.id_user, u.email
            FROM team t
            JOIN users u ON u.id_user = t.id_team
            WHERE t.id_user = ?
        ");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔸 جلب المهام الخاصة بمستخدم
    public function getTasksByUserId($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT id, title, description, created_at
            FROM task
            WHERE id_user = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔸 حذف مهمة بناءً على id_user و id_task
    public function deleteTask($taskId, $userId)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM task
            WHERE id = ? AND id_user = ?
        ");

        return $stmt->execute([$taskId, $userId]);
    }

    // 🔸 إضافة مهمة جديدة لقاعدة البيانات
    public function addTask($userId, $title, $description, $assignedMembers = [])
    {
        $this->pdo->beginTransaction();

        try {
            // 1️⃣ إدخال المهمة الأساسية
            $stmt = $this->pdo->prepare("
                INSERT INTO task (id_user, title, description, created_at)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->execute([$userId, $title, $description]);
            $taskId = $this->pdo->lastInsertId();

            // 2️⃣ حفظ الأعضاء المشاركين في الجدول الوسيط
            if (!empty($assignedMembers)) {
                $insertStmt = $this->pdo->prepare("
                    INSERT INTO task_team (id_task, id_user)
                    VALUES (?, ?)
                ");
                foreach ($assignedMembers as $memberId) {
                    $insertStmt->execute([$taskId, $memberId]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
?>
