<?php
require_once __DIR__ . '/../../config/database.php';

class Portfolio {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($user_id, $judul, $deskripsi, $gambar, $tautan) {
        $sql = "INSERT INTO portofolios (user_id, judul, deskripsi, gambar, tautan) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id, $judul, $deskripsi, $gambar, $tautan]);
    }

    public function getByUserId($user_id) {
        $sql = "SELECT * FROM portofolios WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function getAll() {
        $sql = "SELECT p.*, u.name as student_name, u.nim_nip FROM portofolios p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    public function search($query) {
        $query = "%$query%";
        $sql = "SELECT p.*, u.name as student_name, u.nim_nip 
                FROM portofolios p 
                JOIN users u ON p.user_id = u.id 
                WHERE u.name LIKE ? OR u.nim_nip LIKE ? 
                ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT p.*, u.name as student_name, u.nim_nip 
                FROM portofolios p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $judul, $deskripsi, $gambar, $tautan) {
        if ($gambar) {
            $sql = "UPDATE portofolios SET judul = ?, deskripsi = ?, gambar = ?, tautan = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$judul, $deskripsi, $gambar, $tautan, $id]);
        } else {
            $sql = "UPDATE portofolios SET judul = ?, deskripsi = ?, tautan = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$judul, $deskripsi, $tautan, $id]);
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM portofolios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
