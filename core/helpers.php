<?php
/**
 * Helper Functions
 * Utility functions for the application
 */

require_once __DIR__ . '/Session.php';

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Redirect to internal page
 */
function redirectTo($page) {
    redirect(APP_URL . '/index.php?page=' . $page);
}

/**
 * Sanitize output for HTML
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function csrfToken() {
    if (!Session::has('csrf_token')) {
        Session::set('csrf_token', bin2hex(random_bytes(32)));
    }
    return Session::get('csrf_token');
}

/**
 * Output CSRF hidden input field
 */
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Validate CSRF token
 */
function validateCsrf() {
    $token = $_POST['csrf_token'] ?? '';
    return hash_equals(Session::get('csrf_token', ''), $token);
}

/**
 * Get asset URL
 */
function asset($path) {
    return ASSETS_URL . '/' . ltrim($path, '/');
}

/**
 * Get upload URL
 */
function upload($path) {
    return UPLOADS_URL . '/' . ltrim($path, '/');
}

/**
 * Format price in Malaysian Ringgit
 */
function formatPrice($price) {
    return 'RM ' . number_format($price, 2);
}

/**
 * Get flash message
 */
function flash($key) {
    return Session::getFlash($key);
}

/**
 * Set flash message
 */
function setFlash($key, $message) {
    Session::flash($key, $message);
}

/**
 * Check if request is POST
 */
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check if request is AJAX
 */
function isAjax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Return JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Get POST value with default
 */
function post($key, $default = '') {
    return $_POST[$key] ?? $default;
}

/**
 * Get GET value with default
 */
function get($key, $default = '') {
    return $_GET[$key] ?? $default;
}

/**
 * Include view file
 */
function view($name, $data = []) {
    extract($data);
    include VIEWS_PATH . '/' . $name . '.php';
}

/**
 * Include layout header
 */
function includeHeader($title = 'Nurdaya Store') {
    $pageTitle = $title;
    include VIEWS_PATH . '/layouts/header.php';
}

/**
 * Include layout footer
 */
function includeFooter() {
    include VIEWS_PATH . '/layouts/footer.php';
}

/**
 * Debug dump and die
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}
