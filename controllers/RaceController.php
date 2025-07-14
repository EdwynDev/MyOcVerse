<?php
class RaceController extends Controller {
    public function create() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $raceModel = new Race();
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => $_POST['name'] ?? '',
                'universe_id' => $_POST['universe_id'] ?: null,
                'description' => $_POST['description'] ?? '',
                'physical_traits' => $_POST['physical_traits'] ?? '',
                'abilities' => $_POST['abilities'] ?? '',
                'culture' => $_POST['culture'] ?? '',
                'lifespan' => $_POST['lifespan'] ?? '',
                'habitat' => $_POST['habitat'] ?? '',
                'weaknesses' => $_POST['weaknesses'] ?? '',
                'privacy' => $_POST['privacy'] ?? 'public',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $raceId = $raceModel->create($data);
            
            if ($raceId) {
                // Ajouter XP
                $userModel = new User();
                $userModel->addXP($_SESSION['user_id'], XP_CREATE_RACE);
                
                $this->redirect("/race/$raceId");
            }
        }
        
        $universeModel = new Universe();
        $userUniverses = $universeModel->getByUser($_SESSION['user_id']);
        
        $this->view('race/create', [
            'universes' => $userUniverses
        ]);
    }
    
    public function show($id) {
        $raceModel = new Race();
        $race = $raceModel->getWithDetails($id);
        
        if (!$race) {
            http_response_code(404);
            return $this->view('404');
        }
        
        if ($race['privacy'] === 'private' && $race['user_id'] != ($_SESSION['user_id'] ?? 0)) {
            http_response_code(403);
            return $this->view('403');
        }
        
        $this->view('race/show', [
            'race' => $race
        ]);
    }
}
?>