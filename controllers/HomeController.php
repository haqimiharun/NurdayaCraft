<?php
/**
 * Home Controller
 * Handles homepage and public product views
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/helpers.php';

class HomeController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Show homepage with products by category
     */
    public function index() {
        // Get all active categories that have active products
        $categories = $this->db->fetchAll(
            "SELECT c.* FROM category c
             WHERE EXISTS (
                 SELECT 1 FROM product p
                 WHERE p.category_id = c.category_id
                 AND p.product_status = 'Y'
             )
             AND c.category_status = 'Y'
             ORDER BY c.category_name"
        );

        // Get products for each category
        $productsByCategory = [];
        foreach ($categories as $category) {
            $products = $this->db->fetchAll(
                "SELECT product_id, product_image, product_name, product_price
                 FROM product
                 WHERE category_id = ? AND product_status = 'Y'
                 ORDER BY product_name",
                [$category['category_id']]
            );
            $productsByCategory[$category['category_id']] = [
                'category' => $category,
                'products' => $products
            ];
        }

        include VIEWS_PATH . '/home.php';
    }

    /**
     * Show single product detail
     */
    public function showcase() {
        $productId = get('product');

        if (empty($productId)) {
            redirect(APP_URL);
        }

        $product = $this->db->fetch(
            "SELECT p.*, c.category_name
             FROM product p
             JOIN category c ON p.category_id = c.category_id
             WHERE p.product_id = ? AND p.product_status = 'Y'",
            [$productId]
        );

        if (!$product) {
            setFlash('error', 'Product not found');
            redirect(APP_URL);
        }

        // Get related products
        $relatedProducts = $this->db->fetchAll(
            "SELECT product_id, product_image, product_name, product_price
             FROM product
             WHERE category_id = ? AND product_id != ? AND product_status = 'Y'
             LIMIT 4",
            [$product['category_id'], $productId]
        );

        include VIEWS_PATH . '/products/showcase.php';
    }

    /**
     * Search products
     */
    public function search() {
        $query = get('search');

        $products = [];
        if (!empty($query)) {
            $searchTerm = '%' . $query . '%';
            $products = $this->db->fetchAll(
                "SELECT p.*, c.category_name
                 FROM product p
                 JOIN category c ON p.category_id = c.category_id
                 WHERE (p.product_name LIKE ? OR p.product_description LIKE ?)
                 AND p.product_status = 'Y'
                 ORDER BY p.product_name",
                [$searchTerm, $searchTerm]
            );
        }

        include VIEWS_PATH . '/search.php';
    }
}
