<?php
class CommunityController extends Controller {
    public function index() {
        $page = $_GET['page'] ?? 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $ocModel = new OC();
        $universeModel = new Universe();
        $raceModel = new Race();
        
        $recentOCs = $ocModel->getPublic($limit, $offset);
        $recentUniverses = $universeModel->getPublic(10, 0);
        $recentRaces = $raceModel->getPublic(10, 0);
        
        $this->view('community/index', [
            'recentOCs' => $recentOCs,
            'recentUniverses' => $recentUniverses,
            'recentRaces' => $recentRaces,
            'currentPage' => $page
        ]);
    }
}
?>