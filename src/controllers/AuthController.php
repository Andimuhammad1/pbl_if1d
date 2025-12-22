<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nim_nip = $_POST['nim_nip'];
            $password = $_POST['password'];

            $user = $this->userModel->login($nim_nip, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                if ($user['role'] === 'dosen') {
                    header('Location: index.php?page=lecturer_dashboard');
                } else {
                    header('Location: index.php?page=student_dashboard');
                }
                exit;
            } else {
                return "Login failed! Please check your NIM/NIP and password.";
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    
    public function register() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $nim_nip = $_POST['nim'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            
            try {
                if ($this->userModel->register($name, $email, $password, $nim_nip, $role)) {
                    header('Location: index.php?page=login&msg=registered');
                    exit;
                } else {
                    return "Registration failed.";
                }
            } catch (Exception $e) {
                return "Registration failed: " . $e->getMessage();
            }
         }
    }
}
?>
