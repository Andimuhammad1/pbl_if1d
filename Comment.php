<?php
require_once __DIR__ . '/../../config/database.php';

class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($portfolio_id, $lecturer_id, $comment, $grade) {
        $sql = "INSERT INTO comments (portofolio_id, lecturer_id, comment, grade) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$portfolio_id, $lecturer_id, $comment, $grade]);
    }

    public function getByPortfolioId($portfolio_id) {
        $sql = "SELECT c.*, u.name as lecturer_name 
                FROM comments c 
                JOIN users u ON c.lecturer_id = u.id 
                WHERE c.portofolio_id = ? 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$portfolio_id]);
        return $stmt->fetchAll();
    }
}
?>
