<?php
class Race extends Model {
    protected $table = 'races';
    
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM races WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getPublic($limit = 20, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT r.*, u.username, u.avatar, un.name as universe_name
            FROM races r
            JOIN users u ON r.user_id = u.id
            LEFT JOIN universes un ON r.universe_id = un.id
            WHERE r.privacy = 'public'
            ORDER BY r.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }
    
    public function getWithDetails($id) {
        $stmt = $this->db->prepare("
            SELECT r.*, u.username, u.avatar, un.name as universe_name
            FROM races r
            JOIN users u ON r.user_id = u.id
            LEFT JOIN universes un ON r.universe_id = un.id
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>