<?php
require_once __DIR__ . '/../Models/Portfolio.php';
require_once __DIR__ . '/../Models/Comment.php';

class LecturerController {
    private $portfolioModel;
    private $commentModel;

    public function __construct($pdo) {
        $this->portfolioModel = new Portfolio($pdo);
        $this->commentModel = new Comment($pdo);
    }

    public function index() {
        $query = $_GET['search'] ?? '';
        if ($query) {
            return $this->portfolioModel->search($query);
        } else {
            return $this->portfolioModel->getAll();
        }
    }

    public function view($id) {
        $portfolio = $this->portfolioModel->getById($id);
        $comments = $this->commentModel->getByPortfolioId($id);
        return ['portfolio' => $portfolio, 'comments' => $comments];
    }

    public function addComment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $portfolio_id = $_POST['portfolio_id'];
             $comment = $_POST['comment'];
             $grade = $_POST['grade'];
             $lecturer_id = $_SESSION['user_id'];

             if ($this->commentModel->create($portfolio_id, $lecturer_id, $comment, $grade)) {
                 header("Location: index.php?page=view_portfolio&id=$portfolio_id");
                 exit;
             } else {
                 return "Failed to add comment.";
             }
        }
    }
}
?>
