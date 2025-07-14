<?php
class LeaderboardController extends Controller {
    public function index() {
        $userModel = new User();
        
        // Top par XP
        $stmt = $this->db->prepare("
            SELECT username, avatar, xp
            FROM users
            ORDER BY xp DESC
            LIMIT 50
        ");
        $stmt->execute();
        $topXP = $stmt->fetchAll();
        
        // Top créateurs d'OC
        $stmt = $this->db->prepare("
            SELECT u.username, u.avatar, COUNT(o.id) as oc_count
            FROM users u
            LEFT JOIN ocs o ON u.id = o.user_id
            GROUP BY u.id
            ORDER BY oc_count DESC
            LIMIT 20
        ");
        $stmt->execute();
        $topOCCreators = $stmt->fetchAll();
        
        // Top par likes reçus
        $stmt = $this->db->prepare("
            SELECT u.username, u.avatar, COUNT(l.id) as likes_count
            FROM users u
            LEFT JOIN likes l ON u.id = l.liked_user_id
            GROUP BY u.id
            ORDER BY likes_count DESC
            LIMIT 20
        ");
        $stmt->execute();
        $topLiked = $stmt->fetchAll();
        
        $this->view('leaderboard', [
            'topXP' => $topXP,
            'topOCCreators' => $topOCCreators,
            'topLiked' => $topLiked
        ]);
    }
}
?>