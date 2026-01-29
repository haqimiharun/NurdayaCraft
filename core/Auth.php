<?php
/**
 * Auth Class
 * Handles authentication with secure password hashing
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';

class Auth {
    /**
     * Attempt to login user
     */
    public static function login($username, $password) {
        $db = Database::getInstance();

        $sql = "SELECT user_id, user_type_id, user_name, user_password
                FROM user
                WHERE user_name = ? AND user_status = 'Y'";

        $user = $db->fetch($sql, [$username]);

        if ($user) {
            // Check if password is hashed (starts with $2y$)
            if (strpos($user['user_password'], '$2y$') === 0) {
                $valid = password_verify($password, $user['user_password']);
            } else {
                // Legacy plain text password (migrate to hash on successful login)
                $valid = ($user['user_password'] === $password);
                if ($valid) {
                    self::updatePasswordHash($user['user_id'], $password);
                }
            }

            if ($valid) {
                Session::regenerate();
                Session::set('user_id', $user['user_id']);
                Session::set('user_type', $user['user_type_id']);
                Session::set('user_name', $user['user_name']);
                return $user;
            }
        }

        return false;
    }

    /**
     * Register new user
     */
    public static function register($username, $email, $password) {
        $db = Database::getInstance();

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (user_type_id, user_name, user_email, user_password, user_status)
                VALUES (2, ?, ?, ?, 'Y')";

        try {
            return $db->insert($sql, [$username, $email, $hashedPassword]);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Logout user
     */
    public static function logout() {
        Session::destroy();
    }

    /**
     * Check if user is logged in
     */
    public static function check() {
        return Session::has('user_id');
    }

    /**
     * Get current user ID
     */
    public static function id() {
        return Session::get('user_id');
    }

    /**
     * Get current user type
     */
    public static function type() {
        return Session::get('user_type');
    }

    /**
     * Get current username
     */
    public static function name() {
        return Session::get('user_name');
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return Session::get('user_type') == 1;
    }

    /**
     * Require authentication (redirect if not logged in)
     */
    public static function requireLogin() {
        if (!self::check()) {
            header('Location: ' . APP_URL . '/index.php?page=login');
            exit;
        }
    }

    /**
     * Require admin role
     */
    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: ' . APP_URL);
            exit;
        }
    }

    /**
     * Update password hash (for migrating plain text passwords)
     */
    private static function updatePasswordHash($userId, $password) {
        $db = Database::getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET user_password = ? WHERE user_id = ?";
        $db->update($sql, [$hashedPassword, $userId]);
    }

    /**
     * Check if username exists
     */
    public static function usernameExists($username) {
        $db = Database::getInstance();
        $sql = "SELECT 1 FROM user WHERE user_name = ?";
        return $db->fetch($sql, [$username]) !== false;
    }

    /**
     * Check if email exists
     */
    public static function emailExists($email) {
        $db = Database::getInstance();
        $sql = "SELECT 1 FROM user WHERE user_email = ?";
        return $db->fetch($sql, [$email]) !== false;
    }
}
