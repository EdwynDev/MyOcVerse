<?php
class OC extends Model {
    protected $table = 'ocs';
    
    public function getByUser($userId, $limit = null) {
        $sql = "SELECT * FROM ocs WHERE user_id = ? ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getPublic($limit = 20, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username, u.avatar
            FROM ocs o
            JOIN users u ON o.user_id = u.id
            WHERE o.privacy = 'public'
            ORDER BY o.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }
    
    public function getWithDetails($id) {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username, u.avatar, un.name as universe_name, r.name as race_name
            FROM ocs o
            JOIN users u ON o.user_id = u.id
            LEFT JOIN universes un ON o.universe_id = un.id
            LEFT JOIN races r ON o.race_id = r.id
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getLikes($ocId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM likes
            WHERE content_type = 'oc' AND content_id = ?
        ");
        $stmt->execute([$ocId]);
        return $stmt->fetch()['count'];
    }
    
    public function isLikedBy($ocId, $userId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM likes
            WHERE content_type = 'oc' AND content_id = ? AND user_id = ?
        ");
        $stmt->execute([$ocId, $userId]);
        return $stmt->fetch()['count'] > 0;
    }
    
    public function addLike($ocId, $userId) {
        $stmt = $this->db->prepare("
            INSERT INTO likes (content_type, content_id, user_id, liked_user_id)
            SELECT 'oc', ?, ?, user_id FROM ocs WHERE id = ?
        ");
        $result = $stmt->execute([$ocId, $userId, $ocId]);
        
        if ($result) {
            // Ajouter XP au créateur
            $stmt = $this->db->prepare("UPDATE users SET xp = xp + ? WHERE id = (SELECT user_id FROM ocs WHERE id = ?)");
            $stmt->execute([XP_RECEIVE_LIKE, $ocId]);
        }
        
        return $result;
    }
    
    public function removeLike($ocId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE content_type = 'oc' AND content_id = ? AND user_id = ?");
        return $stmt->execute([$ocId, $userId]);
    }
}
?>