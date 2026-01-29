<?php
/**
 * Dashboard Controller
 * Handles admin dashboard
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';

class DashboardController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        Auth::requireAdmin();
    }

    /**
     * Show dashboard
     */
    public function index() {
        // Get statistics
        $stats = [
            'total_products' => $this->db->fetchColumn(
                "SELECT COUNT(*) FROM product WHERE product_status = 'Y'"
            ),
            'total_categories' => $this->db->fetchColumn(
                "SELECT COUNT(*) FROM category WHERE category_status = 'Y'"
            ),
            'total_orders' => $this->db->fetchColumn(
                "SELECT COUNT(*) FROM orders"
            ),
            'pending_orders' => $this->db->fetchColumn(
                "SELECT COUNT(*) FROM orders WHERE status = 'P'"
            ),
            'total_users' => $this->db->fetchColumn(
                "SELECT COUNT(*) FROM user WHERE user_status = 'Y'"
            ),
            'total_revenue' => $this->db->fetchColumn(
                "SELECT COALESCE(SUM(subtotal), 0) FROM orders WHERE status = 'Y'"
            )
        ];

        // Get recent orders
        $recentOrders = $this->db->fetchAll(
            "SELECT o.*, p.product_name
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             ORDER BY o.order_id DESC
             LIMIT 5"
        );

        // Get top products
        $topProducts = $this->db->fetchAll(
            "SELECT p.product_name, SUM(o.product_qty) as total_sold, SUM(o.subtotal) as total_revenue
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             GROUP BY o.product_id
             ORDER BY total_sold DESC
             LIMIT 5"
        );

        $pageTitle = 'Dashboard - Admin';
        include VIEWS_PATH . '/dashboard/index.php';
    }
}
