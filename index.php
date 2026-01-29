<?php
/**
 * Nurdaya Store - Main Entry Point (Router)
 *
 * This is the single entry point for the application.
 * All requests are routed through this file.
 */

// Load configuration
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/helpers.php';
require_once __DIR__ . '/core/Session.php';

// Start session
Session::start();

// Get requested page and action
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Route the request
switch ($page) {
    // ============================================
    // PUBLIC PAGES
    // ============================================

    case 'home':
    case '':
        require_once CONTROLLERS_PATH . '/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'showcase':
        require_once CONTROLLERS_PATH . '/HomeController.php';
        $controller = new HomeController();
        $controller->showcase();
        break;

    case 'search':
        require_once CONTROLLERS_PATH . '/HomeController.php';
        $controller = new HomeController();
        $controller->search();
        break;

    // ============================================
    // AUTHENTICATION
    // ============================================

    case 'login':
        require_once CONTROLLERS_PATH . '/AuthController.php';
        $controller = new AuthController();
        if ($action === 'process') {
            $controller->processLogin();
        } else {
            $controller->login();
        }
        break;

    case 'register':
        require_once CONTROLLERS_PATH . '/AuthController.php';
        $controller = new AuthController();
        if ($action === 'process') {
            $controller->processRegister();
        } else {
            $controller->register();
        }
        break;

    case 'logout':
        require_once CONTROLLERS_PATH . '/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    // ============================================
    // ORDERS & CHECKOUT
    // ============================================

    case 'checkout':
        require_once CONTROLLERS_PATH . '/OrderController.php';
        $controller = new OrderController();
        if ($action === 'process') {
            $controller->processCheckout();
        } else {
            $controller->checkout();
        }
        break;

    case 'confirmation':
        require_once CONTROLLERS_PATH . '/OrderController.php';
        $controller = new OrderController();
        $controller->confirmation();
        break;

    case 'my-orders':
        require_once CONTROLLERS_PATH . '/OrderController.php';
        $controller = new OrderController();
        $controller->myOrders();
        break;

    // ============================================
    // ADMIN - DASHBOARD
    // ============================================

    case 'dashboard':
        require_once CONTROLLERS_PATH . '/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    // ============================================
    // ADMIN - PRODUCTS
    // ============================================

    case 'products':
        require_once CONTROLLERS_PATH . '/ProductController.php';
        $controller = new ProductController();

        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            case 'getEditData':
                $controller->getEditData();
                break;
            case 'getImage':
                $controller->getImage();
                break;
            case 'deleteImage':
                $controller->deleteImage();
                break;
            case 'updateImage':
                $controller->updateImage();
                break;
            case 'checkExist':
                $controller->checkExist();
                break;
            default:
                $controller->index();
        }
        break;

    // ============================================
    // ADMIN - CATEGORIES
    // ============================================

    case 'categories':
        require_once CONTROLLERS_PATH . '/CategoryController.php';
        $controller = new CategoryController();

        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            case 'getEditData':
                $controller->getEditData();
                break;
            default:
                $controller->index();
        }
        break;

    // ============================================
    // ADMIN - ORDERS
    // ============================================

    case 'orders':
        require_once CONTROLLERS_PATH . '/OrderController.php';
        $controller = new OrderController();

        switch ($action) {
            case 'updateStatus':
                $controller->updateStatus();
                break;
            case 'getDetails':
                $controller->getDetails();
                break;
            default:
                $controller->index();
        }
        break;

    // ============================================
    // 404 - PAGE NOT FOUND
    // ============================================

    default:
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Page Not Found</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <div class="container text-center py-5">
                <h1 class="display-1">404</h1>
                <p class="lead">Page Not Found</p>
                <a href="' . APP_URL . '" class="btn btn-primary">Go Home</a>
            </div>
        </body>
        </html>';
        break;
}
