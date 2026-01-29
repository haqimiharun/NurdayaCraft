<?php
/**
 * Product Controller
 * Handles product CRUD operations (Admin)
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        Auth::requireAdmin();
    }

    /**
     * List all products
     */
    public function index() {
        $products = $this->db->fetchAll(
            "SELECT p.*, c.category_name
             FROM product p
             JOIN category c ON p.category_id = c.category_id
             WHERE p.product_status != 'D'
             ORDER BY p.product_id DESC"
        );

        $categories = $this->db->fetchAll(
            "SELECT * FROM category WHERE category_status = 'Y' ORDER BY category_name"
        );

        $promotions = $this->db->fetchAll("SELECT * FROM promotion");

        $pageTitle = 'Products - Admin';
        include VIEWS_PATH . '/products/index.php';
    }

    /**
     * Add new product
     */
    public function store() {
        if (!isPost()) {
            redirectTo('products');
        }

        $categoryId = post('product_category');
        $name = post('product_name');
        $description = post('product_desc');
        $price = post('product_price');
        $qty = post('product_qty');
        $status = post('product_status');
        $promotionType = post('product_promotion_type');
        $promotionRate = post('promotion_rate');

        // Handle image upload
        $imageName = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $this->uploadImage($_FILES['product_image']);
            if (!$imageName) {
                setFlash('error', 'Failed to upload image');
                redirectTo('products');
            }
        }

        // Build query
        if (empty($promotionType)) {
            $sql = "INSERT INTO product (category_id, product_name, product_description, product_price, product_qty, product_status, product_image)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [$categoryId, $name, $description, $price, $qty, $status, $imageName];
        } else {
            $sql = "INSERT INTO product (category_id, promotion_id, promotion_rate, product_name, product_description, product_price, product_qty, product_status, product_image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = [$categoryId, $promotionType, $promotionRate, $name, $description, $price, $qty, $status, $imageName];
        }

        try {
            $this->db->insert($sql, $params);
            setFlash('success', 'Product added successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to add product');
        }

        redirectTo('products');
    }

    /**
     * Get product data for editing (AJAX)
     */
    public function getEditData() {
        $productId = post('product_id');

        $product = $this->db->fetch(
            "SELECT p.product_id, p.product_name, p.product_description, p.category_id,
                    p.product_price, p.promotion_id, p.promotion_rate, p.product_qty, p.product_status
             FROM product p
             WHERE p.product_id = ?",
            [$productId]
        );

        jsonResponse($product ?: []);
    }

    /**
     * Update product
     */
    public function update() {
        if (!isPost()) {
            redirectTo('products');
        }

        $productId = post('edit_product_id');
        $categoryId = post('edit_product_category');
        $name = post('edit_product_name');
        $description = post('edit_product_desc');
        $price = post('edit_product_price');
        $qty = post('edit_product_qty');
        $status = post('edit_product_status');
        $promotionType = post('edit_product_promotion_type');
        $promotionRate = post('edit_promotion_rate');

        if (empty($promotionType)) {
            $sql = "UPDATE product SET category_id = ?, product_name = ?, product_description = ?,
                    product_price = ?, product_qty = ?, product_status = ?, promotion_id = NULL, promotion_rate = NULL
                    WHERE product_id = ?";
            $params = [$categoryId, $name, $description, $price, $qty, $status, $productId];
        } else {
            $sql = "UPDATE product SET category_id = ?, product_name = ?, product_description = ?,
                    product_price = ?, product_qty = ?, product_status = ?, promotion_id = ?, promotion_rate = ?
                    WHERE product_id = ?";
            $params = [$categoryId, $name, $description, $price, $qty, $status, $promotionType, $promotionRate, $productId];
        }

        try {
            $this->db->update($sql, $params);
            setFlash('success', 'Product updated successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to update product');
        }

        redirectTo('products');
    }

    /**
     * Delete product (soft delete)
     */
    public function delete() {
        $productId = post('product_id');

        try {
            $this->db->update(
                "UPDATE product SET product_status = 'D' WHERE product_id = ?",
                [$productId]
            );
            jsonResponse(['status' => 1]);
        } catch (Exception $e) {
            jsonResponse(['status' => 0, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get product image (AJAX)
     */
    public function getImage() {
        $productId = post('product_id');

        $product = $this->db->fetch(
            "SELECT product_id, product_name, product_image FROM product WHERE product_id = ?",
            [$productId]
        );

        jsonResponse($product ?: []);
    }

    /**
     * Delete product image
     */
    public function deleteImage() {
        $productId = post('product_id');

        try {
            $this->db->update(
                "UPDATE product SET product_image = '' WHERE product_id = ?",
                [$productId]
            );
            jsonResponse(['status' => 1]);
        } catch (Exception $e) {
            jsonResponse(['status' => 0, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update product image
     */
    public function updateImage() {
        if (!isPost()) {
            redirectTo('products');
        }

        $productId = post('edit_image_product_id');

        if (isset($_FILES['edit_product_image']) && $_FILES['edit_product_image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $this->uploadImage($_FILES['edit_product_image']);
            if ($imageName) {
                $this->db->update(
                    "UPDATE product SET product_image = ? WHERE product_id = ?",
                    [$imageName, $productId]
                );
                setFlash('success', 'Image updated successfully');
            } else {
                setFlash('error', 'Failed to upload image');
            }
        }

        redirectTo('products');
    }

    /**
     * Check if product name exists (AJAX)
     */
    public function checkExist() {
        $name = post('name');

        $exists = $this->db->fetch(
            "SELECT 1 FROM product WHERE product_name = ? AND product_status != 'D'",
            [$name]
        );

        echo $exists ? 1 : 0;
        exit;
    }

    /**
     * Upload product image
     */
    private function uploadImage($file) {
        $targetDir = UPLOADS_PATH . '/products/';
        $fileName = basename($file['name']);
        $targetPath = $targetDir . $fileName;

        // Check file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }

        return false;
    }
}
