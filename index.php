<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

// Simple Router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

$authController = new AuthController($pdo);

if ($action === 'login') {
    $error = $authController->login();
    if ($error) {
        require __DIR__ . '/../src/Views/auth/login.php';
    }
    exit;
}

if ($action === 'register') {
    $error = $authController->register();
    if ($error) {
        require __DIR__ . '/../src/Views/auth/register.php';
    }
    exit;
}

if ($action === 'logout') {
    $authController->logout();
}

if ($action === 'create_portfolio') {
    require_once __DIR__ . '/../src/Controllers/PortfolioController.php';
    $portfolioController = new PortfolioController($pdo);
    $portfolioController->create();
}

if ($action === 'delete_portfolio') {
    require_once __DIR__ . '/../src/Controllers/PortfolioController.php';
    $portfolioController = new PortfolioController($pdo);
    $portfolioController->delete($_GET['id']);
}

if ($action === 'add_grade') {
    require_once __DIR__ . '/../src/Controllers/LecturerController.php';
    $lecturerController = new LecturerController($pdo);
    $lecturerController->addComment();
}

// Public Routes (Home, Login, Register, View Portfolio - maybe?)
if (!isset($_SESSION['user_id']) && !in_array($page, ['home', 'login', 'register', 'view_portfolio'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'home':
        require_once __DIR__ . '/../src/Controllers/HomeController.php';
        $homeController = new HomeController($pdo);
        $portfolios = $homeController->index();
        require __DIR__ . '/../src/Views/home.php';
        break;

    case 'login':
        require __DIR__ . '/../src/Views/auth/login.php';
        break;

    case 'register':
        require __DIR__ . '/../src/Views/auth/register.php';
        break;
        
    case 'student_dashboard':
        // Check role
        if ($_SESSION['role'] !== 'mahasiswa') {
             echo "Access Denied"; exit;
        }
        
        require_once __DIR__ . '/../src/Controllers/PortfolioController.php';
        $portfolioController = new PortfolioController($pdo);
        $portfolios = $portfolioController->indexStudent();

        require __DIR__ . '/../src/Views/student/dashboard.php';
        break;

    case 'create_portfolio':
        if ($_SESSION['role'] !== 'mahasiswa') { echo "Access Denied"; exit; }
        require __DIR__ . '/../src/Views/student/create.php';
        break;

    case 'lecturer_dashboard':
        // Check role
        if ($_SESSION['role'] !== 'dosen') {
             echo "Access Denied"; exit;
        }
        require_once __DIR__ . '/../src/Controllers/LecturerController.php';
        $lecturerController = new LecturerController($pdo);
        $portfolios = $lecturerController->index();
        require __DIR__ . '/../src/Views/lecturer/dashboard.php';
        break;

    case 'view_portfolio':
        require_once __DIR__ . '/../src/Controllers/LecturerController.php';
        $lecturerController = new LecturerController($pdo);
        $data = $lecturerController->view($_GET['id']);
        $portfolio = $data['portfolio'];
        $comments = $data['comments'];
        require __DIR__ . '/../src/Views/lecturer/view.php';
        break;

    case 'profile':
        require_once __DIR__ . '/../src/Controllers/ProfileController.php';
        $profileController = new ProfileController($pdo);
        if ($action === 'update') {
            $profileController->update();
        } else {
            $profileController->index();
        }
        break;


    default:
        echo "404 Page Not Found";
        break;
}
?>
