<?php
class User extends Model {
    protected $table = 'users';
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function addXP($userId, $amount) {
        $stmt = $this->db->prepare("UPDATE users SET xp = xp + ? WHERE id = ?");
        return $stmt->execute([$amount, $userId]);
    }
    
    public function getStats($userId) {
        $stmt = $this->db->prepare("
            SELECT 
                (SELECT COUNT(*) FROM ocs WHERE user_id = ?) as oc_count,
                (SELECT COUNT(*) FROM likes WHERE liked_user_id = ?) as likes_received,
                (SELECT COUNT(*) FROM comments WHERE user_id = ?) as comments_made,
                (SELECT COUNT(*) FROM universes WHERE user_id = ?) as universe_count,
                (SELECT COUNT(*) FROM races WHERE user_id = ?) as race_count
        ");
        $stmt->execute([$userId, $userId, $userId, $userId, $userId]);
        return $stmt->fetch();
    }
    
    public function getBadges($userId) {
        $stmt = $this->db->prepare("
            SELECT b.* FROM badges b
            JOIN user_badges ub ON b.id = ub.badge_id
            WHERE ub.user_id = ?
            ORDER BY ub.earned_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>