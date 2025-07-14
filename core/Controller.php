<?php
class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    protected function view($view, $data = []) {
        extract($data);
        include "views/$view.php";
    }
    
    protected function redirect($path) {
        header("Location: $path");
        exit;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    protected function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
}
?>