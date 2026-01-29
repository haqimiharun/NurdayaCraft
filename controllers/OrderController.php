<?php
/**
 * Order Controller
 * Handles order management
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';

class OrderController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * List all orders (Admin)
     */
    public function index() {
        Auth::requireAdmin();

        $orders = $this->db->fetchAll(
            "SELECT o.*, p.product_name, p.product_image
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             ORDER BY o.order_id DESC"
        );

        $pageTitle = 'Orders - Admin';
        include VIEWS_PATH . '/orders/index.php';
    }

    /**
     * Show checkout page
     */
    public function checkout() {
        $productId = get('product');

        if (empty($productId)) {
            redirect(APP_URL);
        }

        $product = $this->db->fetch(
            "SELECT * FROM product WHERE product_id = ? AND product_status = 'Y'",
            [$productId]
        );

        if (!$product) {
            setFlash('error', 'Product not found');
            redirect(APP_URL);
        }

        $pageTitle = 'Checkout';
        include VIEWS_PATH . '/orders/checkout.php';
    }

    /**
     * Process checkout
     */
    public function processCheckout() {
        if (!isPost()) {
            redirect(APP_URL);
        }

        $productId = post('product_id');
        $qty = post('qty');
        $email = post('email');
        $address = post('address');
        $city = post('city');
        $postcode = post('postcode');
        $states = post('states');
        $phone = post('phone_number');

        // Get product price
        $product = $this->db->fetch(
            "SELECT product_price FROM product WHERE product_id = ?",
            [$productId]
        );

        if (!$product) {
            setFlash('error', 'Product not found');
            redirect(APP_URL);
        }

        $subtotal = $product['product_price'] * $qty;
        $userId = Auth::check() ? Auth::id() : null;

        // Generate tracking number
        $trackingNo = 'ND' . date('YmdHis') . rand(100, 999);

        try {
            $orderId = $this->db->insert(
                "INSERT INTO orders (product_id, product_qty, subtotal, user_id, email, address, city, postcode, states, phone_number, tracking_no, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'P')",
                [$productId, $qty, $subtotal, $userId, $email, $address, $city, $postcode, $states, $phone, $trackingNo]
            );

            // Update product quantity
            $this->db->update(
                "UPDATE product SET product_qty = product_qty - ? WHERE product_id = ?",
                [$qty, $productId]
            );

            redirect(APP_URL . '/index.php?page=confirmation&order=' . $orderId);
        } catch (Exception $e) {
            setFlash('error', 'Failed to process order');
            redirect(APP_URL . '/index.php?page=checkout&product=' . $productId);
        }
    }

    /**
     * Order confirmation page
     */
    public function confirmation() {
        $orderId = get('order');

        if (empty($orderId)) {
            redirect(APP_URL);
        }

        $order = $this->db->fetch(
            "SELECT o.*, p.product_name, p.product_image, p.product_price
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             WHERE o.order_id = ?",
            [$orderId]
        );

        if (!$order) {
            setFlash('error', 'Order not found');
            redirect(APP_URL);
        }

        $pageTitle = 'Order Confirmation';
        include VIEWS_PATH . '/orders/confirmation.php';
    }

    /**
     * Update order status (Admin)
     */
    public function updateStatus() {
        Auth::requireAdmin();

        if (!isPost()) {
            redirectTo('orders');
        }

        $orderId = post('order_id');
        $status = post('status');
        $trackingNo = post('tracking_no');

        try {
            $this->db->update(
                "UPDATE orders SET status = ?, tracking_no = ? WHERE order_id = ?",
                [$status, $trackingNo, $orderId]
            );
            setFlash('success', 'Order updated successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to update order');
        }

        redirectTo('orders');
    }

    /**
     * Get order details (AJAX)
     */
    public function getDetails() {
        Auth::requireAdmin();

        $orderId = post('order_id');

        $order = $this->db->fetch(
            "SELECT o.*, p.product_name, p.product_image
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             WHERE o.order_id = ?",
            [$orderId]
        );

        jsonResponse($order ?: []);
    }

    /**
     * User's orders
     */
    public function myOrders() {
        Auth::requireLogin();

        $orders = $this->db->fetchAll(
            "SELECT o.*, p.product_name, p.product_image
             FROM orders o
             JOIN product p ON o.product_id = p.product_id
             WHERE o.user_id = ?
             ORDER BY o.order_id DESC",
            [Auth::id()]
        );

        $pageTitle = 'My Orders';
        include VIEWS_PATH . '/orders/my-orders.php';
    }
}
