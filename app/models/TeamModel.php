<?php
class TeamModel {
    private $pdo;

    // 🧩 ربط قاعدة البيانات عند الإنشاء
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /* ---------------------------------------------------
       🔹 جلب أعضاء الفريق
    --------------------------------------------------- */
    public function getTeamMembers($id_user) {
        $stmt = $this->pdo->prepare("
            SELECT u.id_user, u.email
            FROM team t
            JOIN users u ON t.id_team = u.id_user
            WHERE t.id_user = ?
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------------------------------------------------
       🔹 البحث / الإكمال التلقائي
    --------------------------------------------------- */
    public function searchUsers($email, $id_user) {
        $stmt = $this->pdo->prepare("
            SELECT id_user, email
            FROM users
            WHERE email LIKE ? AND id_user != ?
            ORDER BY email ASC
            LIMIT 10
        ");
        $stmt->execute(["%$email%", $id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------------------------------------------------
       🔹 التحقق إن كان العضو مضاف مسبقًا
    --------------------------------------------------- */
    public function isAlreadyInTeam($id_user, $friend_id) {
        $check = $this->pdo->prepare("SELECT 1 FROM team WHERE id_user = ? AND id_team = ?");
        $check->execute([$id_user, $friend_id]);
        return $check->rowCount() > 0;
    }

    /* ---------------------------------------------------
       🔹 إضافة عضو إلى الفريق
    --------------------------------------------------- */
    public function addMember($id_user, $friend_id) {
        $stmt = $this->pdo->prepare("INSERT INTO team (id_user, id_team) VALUES (?, ?)");
        return $stmt->execute([$id_user, $friend_id]);
    }

    /* ---------------------------------------------------
       🔹 إزالة عضو من الفريق
    --------------------------------------------------- */
    public function removeMember($id_user, $id_remove) {
        $stmt = $this->pdo->prepare("DELETE FROM team WHERE id_user = ? AND id_team = ?");
        return $stmt->execute([$id_user, $id_remove]);
    }
}
