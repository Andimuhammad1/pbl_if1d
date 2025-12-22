<?php
require_once __DIR__ . '/../Models/Portfolio.php';

class HomeController {
    private $portfolioModel;

    public function __construct($pdo) {
        $this->portfolioModel = new Portfolio($pdo);
    }

    public function index() {
        // Fetch latest 6 portfolios for the home page
        $allPortfolios = $this->portfolioModel->getAll(); // In a real app, use pagination or limit
        return array_slice($allPortfolios, 0, 6);
    }
}
?>
