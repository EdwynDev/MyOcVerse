<?php
class UniverseController extends Controller {
    public function create() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $universeModel = new Universe();
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => $_POST['name'] ?? '',
                'genre' => $_POST['genre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'technology_level' => $_POST['technology_level'] ?? '',
                'magic_system' => $_POST['magic_system'] ?? '',
                'geography' => $_POST['geography'] ?? '',
                'history' => $_POST['history'] ?? '',
                'factions' => $_POST['factions'] ?? '',
                'rules' => $_POST['rules'] ?? '',
                'privacy' => $_POST['privacy'] ?? 'public',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $universeId = $universeModel->create($data);
            
            if ($universeId) {
                // Ajouter XP
                $userModel = new User();
                $userModel->addXP($_SESSION['user_id'], XP_CREATE_UNIVERSE);
                
                $this->redirect("/universe/$universeId");
            }
        }
        
        $this->view('universe/create');
    }
    
    public function show($id) {
        $universeModel = new Universe();
        $universe = $universeModel->getWithDetails($id);
        
        if (!$universe) {
            http_response_code(404);
            return $this->view('404');
        }
        
        if ($universe['privacy'] === 'private' && $universe['user_id'] != ($_SESSION['user_id'] ?? 0)) {
            http_response_code(403);
            return $this->view('403');
        }
        
        $races = $universeModel->getRaces($id);
        $ocs = $universeModel->getOCs($id);
        
        $this->view('universe/show', [
            'universe' => $universe,
            'races' => $races,
            'ocs' => $ocs
        ]);
    }
}
?>