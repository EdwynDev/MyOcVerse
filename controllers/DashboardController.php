<?php
class DashboardController extends Controller {
    public function index() {
        $this->requireLogin();
        
        $user = $this->getCurrentUser();
        $userModel = new User();
        $ocModel = new OC();
        $universeModel = new Universe();
        $raceModel = new Race();
        
        $stats = $userModel->getStats($_SESSION['user_id']);
        $badges = $userModel->getBadges($_SESSION['user_id']);
        $recentOCs = $ocModel->getByUser($_SESSION['user_id'], 5);
        $recentUniverses = $universeModel->getByUser($_SESSION['user_id']);
        $recentRaces = $raceModel->getByUser($_SESSION['user_id']);
        
        $this->view('dashboard', [
            'user' => $user,
            'stats' => $stats,
            'badges' => $badges,
            'recentOCs' => $recentOCs,
            'recentUniverses' => $recentUniverses,
            'recentRaces' => $recentRaces
        ]);
    }
}
?>