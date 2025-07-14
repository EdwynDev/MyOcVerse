<?php
class HomeController extends Controller {
    public function index() {
        $ocModel = new OC();
        $universeModel = new Universe();
        $raceModel = new Race();
        
        $recentOCs = $ocModel->getPublic(8);
        $recentUniverses = $universeModel->getPublic(4);
        $recentRaces = $raceModel->getPublic(4);
        
        $this->view('home', [
            'recentOCs' => $recentOCs,
            'recentUniverses' => $recentUniverses,
            'recentRaces' => $recentRaces
        ]);
    }
}
?>