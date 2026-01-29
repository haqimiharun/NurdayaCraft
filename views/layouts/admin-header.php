<?php
/**
 * Admin Header Layout Template
 */

require_once __DIR__ . '/../../core/Session.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/helpers.php';
require_once __DIR__ . '/../../config/config.php';

Session::start();
Auth::requireAdmin();

$pageTitle = $pageTitle ?? 'Admin - Nurdaya Store';
$currentPage = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/logo-removebg-preview.png') ?>">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="mb-4">
                <a href="<?= APP_URL ?>" class="navbar-brand">NurDaya Store</a>
            </div>

            <nav>
                <a href="<?= APP_URL ?>/index.php?page=dashboard" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                    Dashboard
                </a>
                <a href="<?= APP_URL ?>/index.php?page=products" class="nav-link <?= $currentPage === 'products' ? 'active' : '' ?>">
                    Products
                </a>
                <a href="<?= APP_URL ?>/index.php?page=categories" class="nav-link <?= $currentPage === 'categories' ? 'active' : '' ?>">
                    Categories
                </a>
                <a href="<?= APP_URL ?>/index.php?page=orders" class="nav-link <?= $currentPage === 'orders' ? 'active' : '' ?>">
                    Orders
                </a>
                <a href="<?= APP_URL ?>/index.php?page=users" class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                    Users
                </a>
                <hr>
                <a href="<?= APP_URL ?>" class="nav-link">View Store</a>
                <a href="<?= APP_URL ?>/index.php?page=logout" class="nav-link">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Flash Messages -->
            <?php if ($success = flash('success')): ?>
                <div class="alert alert-success" data-auto-dismiss="5000"><?= e($success) ?></div>
            <?php endif; ?>

            <?php if ($error = flash('error')): ?>
                <div class="alert alert-danger" data-auto-dismiss="5000"><?= e($error) ?></div>
            <?php endif; ?>
