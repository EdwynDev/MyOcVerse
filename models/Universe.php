<?php
class Universe extends Model {
    protected $table = 'universes';
    
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM universes WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getPublic($limit = 20, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT u.*, us.username, us.avatar
            FROM universes u
            JOIN users us ON u.user_id = us.id
            WHERE u.privacy = 'public'
            ORDER BY u.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }
    
    public function getWithDetails($id) {
        $stmt = $this->db->prepare("
            SELECT u.*, us.username, us.avatar
            FROM universes u
            JOIN users us ON u.user_id = us.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getRaces($universeId) {
        $stmt = $this->db->prepare("SELECT * FROM races WHERE universe_id = ? ORDER BY name");
        $stmt->execute([$universeId]);
        return $stmt->fetchAll();
    }
    
    public function getOCs($universeId) {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username
            FROM ocs o
            JOIN users u ON o.user_id = u.id
            WHERE o.universe_id = ?
            ORDER BY o.name
        ");
        $stmt->execute([$universeId]);
        return $stmt->fetchAll();
    }
}
?>