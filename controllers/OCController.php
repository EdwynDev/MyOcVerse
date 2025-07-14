<?php
class OCController extends Controller {
    public function create() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ocModel = new OC();
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => $_POST['name'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'age' => $_POST['age'] ?? '',
                'race_id' => $_POST['race_id'] ?: null,
                'universe_id' => $_POST['universe_id'] ?: null,
                'avatar' => $_POST['avatar'] ?? '',
                'physical_description' => $_POST['physical_description'] ?? '',
                'mental_description' => $_POST['mental_description'] ?? '',
                'background' => $_POST['background'] ?? '',
                'abilities' => $_POST['abilities'] ?? '',
                'attributes' => json_encode($_POST['attributes'] ?? []),
                'privacy' => $_POST['privacy'] ?? 'public',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $ocId = $ocModel->create($data);
            
            if ($ocId) {
                // Ajouter XP
                $userModel = new User();
                $userModel->addXP($_SESSION['user_id'], XP_CREATE_OC);
                
                $this->redirect("/oc/$ocId");
            }
        }
        
        $universeModel = new Universe();
        $raceModel = new Race();
        $userUniverses = $universeModel->getByUser($_SESSION['user_id']);
        $userRaces = $raceModel->getByUser($_SESSION['user_id']);
        
        $this->view('oc/create', [
            'universes' => $userUniverses,
            'races' => $userRaces
        ]);
    }
    
    public function show($id) {
        $ocModel = new OC();
        $oc = $ocModel->getWithDetails($id);
        
        if (!$oc) {
            http_response_code(404);
            return $this->view('404');
        }
        
        // Vérifier les permissions
        if ($oc['privacy'] === 'private' && $oc['user_id'] != ($_SESSION['user_id'] ?? 0)) {
            http_response_code(403);
            return $this->view('403');
        }
        
        $likes = $ocModel->getLikes($id);
        $isLiked = false;
        
        if ($this->isLoggedIn()) {
            $isLiked = $ocModel->isLikedBy($id, $_SESSION['user_id']);
        }
        
        // Système de likes AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'like') {
            $this->requireLogin();
            
            if ($isLiked) {
                $ocModel->removeLike($id, $_SESSION['user_id']);
            } else {
                $ocModel->addLike($id, $_SESSION['user_id']);
            }
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }
        
        $this->view('oc/show', [
            'oc' => $oc,
            'likes' => $likes,
            'isLiked' => $isLiked
        ]);
    }
    
    public function edit($id) {
        $this->requireLogin();
        
        $ocModel = new OC();
        $oc = $ocModel->find($id);
        
        if (!$oc || $oc['user_id'] != $_SESSION['user_id']) {
            http_response_code(404);
            return $this->view('404');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'age' => $_POST['age'] ?? '',
                'race_id' => $_POST['race_id'] ?: null,
                'universe_id' => $_POST['universe_id'] ?: null,
                'avatar' => $_POST['avatar'] ?? '',
                'physical_description' => $_POST['physical_description'] ?? '',
                'mental_description' => $_POST['mental_description'] ?? '',
                'background' => $_POST['background'] ?? '',
                'abilities' => $_POST['abilities'] ?? '',
                'attributes' => json_encode($_POST['attributes'] ?? []),
                'privacy' => $_POST['privacy'] ?? 'public',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($ocModel->update($id, $data)) {
                $this->redirect("/oc/$id");
            }
        }
        
        $universeModel = new Universe();
        $raceModel = new Race();
        $userUniverses = $universeModel->getByUser($_SESSION['user_id']);
        $userRaces = $raceModel->getByUser($_SESSION['user_id']);
        
        $this->view('oc/edit', [
            'oc' => $oc,
            'universes' => $userUniverses,
            'races' => $userRaces
        ]);
    }
}
?>