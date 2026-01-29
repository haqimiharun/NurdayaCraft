<?php
/**
 * Session Class
 * Handles session management securely
 */

class Session {
    private static $started = false;

    /**
     * Start session with secure settings
     */
    public static function start() {
        if (self::$started) {
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            // Set secure session settings
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_httponly', 1);

            session_start();
            self::$started = true;
        }
    }

    /**
     * Set session value
     */
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     */
    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     */
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     */
    public static function remove($key) {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Destroy entire session
     */
    public static function destroy() {
        self::start();
        $_SESSION = [];
        session_destroy();
        self::$started = false;
    }

    /**
     * Regenerate session ID (call after login for security)
     */
    public static function regenerate() {
        self::start();
        session_regenerate_id(true);
    }

    /**
     * Flash message - set
     */
    public static function flash($key, $message) {
        self::set('flash_' . $key, $message);
    }

    /**
     * Flash message - get and remove
     */
    public static function getFlash($key) {
        $message = self::get('flash_' . $key);
        self::remove('flash_' . $key);
        return $message;
    }
}
