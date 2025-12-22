<?php
require_once __DIR__ . '/../Models/Portfolio.php';

class PortfolioController {
    private $portfolioModel;

    public function __construct($pdo) {
        $this->portfolioModel = new Portfolio($pdo);
    }

    public function indexStudent() {
        if (!isset($_SESSION['user_id'])) return [];
        return $this->portfolioModel->getByUserId($_SESSION['user_id']);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $title = $_POST['title'];
             $description = $_POST['description'];
             $repo_link = $_POST['repo_link'];
             $user_id = $_SESSION['user_id'];
             
             // Handle Image Upload
             $image_path = null;
             if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                 $uploadDir = __DIR__ . '/../../public/uploads/';
                 if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                 
                 $fileName = time() . '_' . basename($_FILES['image']['name']);
                 $targetPath = $uploadDir . $fileName;
                 
                 if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                     $image_path = 'uploads/' . $fileName;
                 }
             }

             if ($this->portfolioModel->create($user_id, $title, $description, $image_path, $repo_link)) {
                 header('Location: index.php?page=student_dashboard');
                 exit;
             } else {
                 return "Failed to create portfolio.";
             }
        }
    }

    public function update($id) {
         // Logic to update (similar to create but logic for keeping old image if new one not uploaded)
         // For brevity, basic structure
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $title = $_POST['title'];
             $description = $_POST['description'];
             $repo_link = $_POST['repo_link'];
             
             $image_path = null;
             if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                 $uploadDir = __DIR__ . '/../../public/uploads/';
                 $fileName = time() . '_' . basename($_FILES['image']['name']);
                 if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                     $image_path = 'uploads/' . $fileName;
                 }
             }
             
             $this->portfolioModel->update($id, $title, $description, $image_path, $repo_link);
             header('Location: index.php?page=student_dashboard');
             exit;
         }
    }

    public function delete($id) {
        $this->portfolioModel->delete($id);
        header('Location: index.php?page=student_dashboard');
        exit;
    }
}
?>
