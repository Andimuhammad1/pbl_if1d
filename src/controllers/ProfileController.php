<?php
require_once __DIR__ . '/../Models/User.php';

class ProfileController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $user = $this->userModel->getById($_SESSION['user_id']);
        require __DIR__ . '/../Views/student/profile.php';
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [];
            // Collect allowed fields
            $allowed = ['name', 'email', 'nim_nip', 'jurusan', 'deskripsi', 'sma', 'univ', 'prestasi', 'linkedin', 'instagram'];
            foreach ($allowed as $field) {
                if (isset($_POST[$field])) {
                    $data[$field] = $_POST[$field];
                }
            }

            // Handle Photo Upload
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['foto']['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                    $data['foto'] = 'uploads/profiles/' . $fileName;
                }
            }

            if ($this->userModel->updateProfile($_SESSION['user_id'], $data)) {
                // Update session name if changed
                if (isset($data['name'])) {
                    $_SESSION['name'] = $data['name'];
                }
                echo json_encode(['success' => true, 'message' => 'Profil berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui profil']);
            }
            exit;
        }
    }
}
?>
