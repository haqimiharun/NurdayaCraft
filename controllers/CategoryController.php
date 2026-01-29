<?php
/**
 * Category Controller
 * Handles category CRUD operations (Admin)
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/helpers.php';

class CategoryController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        Auth::requireAdmin();
    }

    /**
     * List all categories
     */
    public function index() {
        $categories = $this->db->fetchAll(
            "SELECT c.*, (SELECT COUNT(*) FROM product p WHERE p.category_id = c.category_id AND p.product_status = 'Y') as product_count
             FROM category c
             WHERE c.category_status != 'D'
             ORDER BY c.category_name"
        );

        $pageTitle = 'Categories - Admin';
        include VIEWS_PATH . '/categories/index.php';
    }

    /**
     * Add new category
     */
    public function store() {
        if (!isPost()) {
            redirectTo('categories');
        }

        $name = post('category_name');
        $status = post('category_status');

        if (empty($name)) {
            setFlash('error', 'Category name is required');
            redirectTo('categories');
        }

        // Check if category exists
        $exists = $this->db->fetch(
            "SELECT 1 FROM category WHERE category_name = ? AND category_status != 'D'",
            [$name]
        );

        if ($exists) {
            setFlash('error', 'Category already exists');
            redirectTo('categories');
        }

        try {
            $this->db->insert(
                "INSERT INTO category (category_name, category_status) VALUES (?, ?)",
                [$name, $status]
            );
            setFlash('success', 'Category added successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to add category');
        }

        redirectTo('categories');
    }

    /**
     * Get category data for editing (AJAX)
     */
    public function getEditData() {
        $categoryId = post('category_id');

        $category = $this->db->fetch(
            "SELECT * FROM category WHERE category_id = ?",
            [$categoryId]
        );

        jsonResponse($category ?: []);
    }

    /**
     * Update category
     */
    public function update() {
        if (!isPost()) {
            redirectTo('categories');
        }

        $categoryId = post('edit_category_id');
        $name = post('edit_category_name');
        $status = post('edit_category_status');

        if (empty($name)) {
            setFlash('error', 'Category name is required');
            redirectTo('categories');
        }

        try {
            $this->db->update(
                "UPDATE category SET category_name = ?, category_status = ? WHERE category_id = ?",
                [$name, $status, $categoryId]
            );
            setFlash('success', 'Category updated successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to update category');
        }

        redirectTo('categories');
    }

    /**
     * Delete category (soft delete)
     */
    public function delete() {
        $categoryId = post('category_id');

        // Check if category has products
        $hasProducts = $this->db->fetch(
            "SELECT 1 FROM product WHERE category_id = ? AND product_status = 'Y'",
            [$categoryId]
        );

        if ($hasProducts) {
            jsonResponse(['status' => 0, 'error' => 'Cannot delete category with active products']);
        }

        try {
            $this->db->update(
                "UPDATE category SET category_status = 'D' WHERE category_id = ?",
                [$categoryId]
            );
            jsonResponse(['status' => 1]);
        } catch (Exception $e) {
            jsonResponse(['status' => 0, 'error' => $e->getMessage()]);
        }
    }
}
