<?php
class TeamModel {
    private $pdo;

    // 🔹 الربط مع قاعدة البيانات عند إنشاء الكائن
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /* ---------------------------------------------------
       🔸 جلب أعضاء الفريق للمستخدم الحالي
    --------------------------------------------------- */
    public function getTeamMembers($userId) {
        $stmt = $this->pdo->prepare("
            SELECT u.id_user, u.email
            FROM team t
            JOIN users u ON u.id_user = t.id_team
            WHERE t.id_user = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
