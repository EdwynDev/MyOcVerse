<?php
class AuthController extends Controller {
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $this->redirect('/dashboard');
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }
        
        $this->view('auth/login', ['error' => $error ?? null]);
    }
    
    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            if (empty($username) || strlen($username) < 3) {
                $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            }
            
            if (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
            
            $userModel = new User();
            
            if ($userModel->findByEmail($email)) {
                $errors[] = "Cet email est déjà utilisé.";
            }
            
            if ($userModel->findByUsername($username)) {
                $errors[] = "Ce nom d'utilisateur est déjà pris.";
            }
            
            if (empty($errors)) {
                $userId = $userModel->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'xp' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                $this->redirect('/dashboard');
            }
        }
        
        $this->view('auth/register', ['errors' => $errors ?? []]);
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/');
    }
}
?>