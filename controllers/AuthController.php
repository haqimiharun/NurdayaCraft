<?php
/**
 * Auth Controller
 * Handles login, registration, and logout
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';

class AuthController {

    /**
     * Show login page
     */
    public function login() {
        if (Auth::check()) {
            $this->redirectAfterLogin();
        }

        $error = isset($_GET['status']) && $_GET['status'] === 'f';
        include VIEWS_PATH . '/auth/login.php';
    }

    /**
     * Process login
     */
    public function processLogin() {
        if (!isPost()) {
            redirectTo('login');
        }

        $username = post('username');
        $password = post('password');

        if (empty($username) || empty($password)) {
            setFlash('error', 'Please fill in all fields');
            redirectTo('login');
        }

        $user = Auth::login($username, $password);

        if ($user) {
            setFlash('success', 'Welcome back, ' . $user['user_name'] . '!');
            $this->redirectAfterLogin();
        } else {
            setFlash('error', 'Invalid username or password');
            redirectTo('login');
        }
    }

    /**
     * Show registration page
     */
    public function register() {
        if (Auth::check()) {
            redirect(APP_URL);
        }

        include VIEWS_PATH . '/auth/register.php';
    }

    /**
     * Process registration
     */
    public function processRegister() {
        if (!isPost()) {
            redirectTo('register');
        }

        $username = post('username');
        $email = post('email');
        $password = post('password');
        $confirmPassword = post('confirm_password');

        // Validation
        $errors = [];

        if (empty($username)) {
            $errors[] = 'Username is required';
        } elseif (Auth::usernameExists($username)) {
            $errors[] = 'Username already exists';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        } elseif (Auth::emailExists($email)) {
            $errors[] = 'Email already exists';
        }

        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirectTo('register');
        }

        $userId = Auth::register($username, $email, $password);

        if ($userId) {
            setFlash('success', 'Registration successful! Please login.');
            redirectTo('login');
        } else {
            setFlash('error', 'Registration failed. Please try again.');
            redirectTo('register');
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        Auth::logout();
        setFlash('success', 'You have been logged out');
        redirect(APP_URL);
    }

    /**
     * Redirect after successful login based on user type
     */
    private function redirectAfterLogin() {
        if (Auth::isAdmin()) {
            redirectTo('orders');
        } else {
            redirect(APP_URL);
        }
    }
}
