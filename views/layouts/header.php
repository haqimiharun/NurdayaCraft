<?php
/**
 * Header Layout Template
 * Reusable header with navbar
 */

require_once __DIR__ . '/../../core/Session.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/helpers.php';
require_once __DIR__ . '/../../config/config.php';

Session::start();
$pageTitle = $pageTitle ?? 'Nurdaya Store';
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
    <!-- Navbar -->
    <nav class="navbar">
        <a href="<?= APP_URL ?>" class="navbar-brand">NurDaya Store</a>

        <ul class="navbar-nav">
            <li><a href="<?= APP_URL ?>">Home</a></li>
            <li><a href="<?= APP_URL ?>/#product">Categories</a></li>
            <li><a href="#">Latest</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>

        <div class="search-nav">
            <form action="<?= APP_URL ?>" method="GET">
                <input type="text" name="search" placeholder="Search" class="form-control shadow-none" autocomplete="off">
            </form>
            <button type="submit"><img src="<?= asset('images/search.png') ?>" alt="Search"></button>
        </div>

        <div class="navbar-actions">
            <a href="#"><img src="<?= asset('images/bookmark.png') ?>" alt="Bookmarks"></a>
            <a href="#"><img src="<?= asset('images/cart.png') ?>" alt="Cart"></a>

            <?php if (Auth::check()): ?>
                <div class="user-dropdown">
                    <button class="dropdown-toggle btn"><?= e(Auth::name()) ?></button>
                    <div class="dropdown-menu">
                        <?php if (Auth::isAdmin()): ?>
                            <a href="<?= APP_URL ?>/index.php?page=dashboard">Dashboard</a>
                            <a href="<?= APP_URL ?>/index.php?page=products">Products</a>
                            <a href="<?= APP_URL ?>/index.php?page=orders">Orders</a>
                        <?php else: ?>
                            <a href="<?= APP_URL ?>/index.php?page=my-orders">My Orders</a>
                        <?php endif; ?>
                        <a href="<?= APP_URL ?>/index.php?page=logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= APP_URL ?>/index.php?page=login" class="btn btn-primary register-btn">Sign In</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if ($success = flash('success')): ?>
        <div class="container mt-3">
            <div class="alert alert-success" data-auto-dismiss="5000"><?= e($success) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($error = flash('error')): ?>
        <div class="container mt-3">
            <div class="alert alert-danger" data-auto-dismiss="5000"><?= e($error) ?></div>
        </div>
    <?php endif; ?>

    <main>
