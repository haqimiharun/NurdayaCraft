<?php
/**
 * Database Class
 * PDO wrapper with prepared statement support
 */

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        require_once __DIR__ . '/../config/config.php';

        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (APP_ENV === 'development') {
                die("Database connection failed: " . $e->getMessage());
            } else {
                die("Database connection failed. Please try again later.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Execute a query with prepared statements
     */
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Fetch single row
     */
    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Fetch single column value
     */
    public function fetchColumn($sql, $params = []) {
        return $this->query($sql, $params)->fetchColumn();
    }

    /**
     * Insert and return last insert ID
     */
    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }

    /**
     * Update and return affected rows
     */
    public function update($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Delete and return affected rows
     */
    public function delete($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Get row count
     */
    public function count($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
