<?php
/**
 * Categories Admin View
 */

include __DIR__ . '/../layouts/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categories</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table" id="categoriesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_id'] ?></td>
                    <td><?= e($category['category_name']) ?></td>
                    <td><?= $category['product_count'] ?></td>
                    <td>
                        <?php if ($category['category_status'] === 'Y'): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-btn"
                                data-id="<?= $category['category_id'] ?>"
                                data-name="<?= e($category['category_name']) ?>"
                                data-status="<?= $category['category_status'] ?>">Edit</button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $category['category_id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= APP_URL ?>/index.php?page=categories&action=store" method="POST">
                <?= csrfField() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="category_status">
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= APP_URL ?>/index.php?page=categories&action=update" method="POST">
                <?= csrfField() ?>
                <input type="hidden" name="edit_category_id" id="edit_category_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="edit_category_name" id="edit_category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="edit_category_status" id="edit_category_status">
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#categoriesTable').DataTable();

    // Edit button
    $('.edit-btn').click(function() {
        $('#edit_category_id').val($(this).data('id'));
        $('#edit_category_name').val($(this).data('name'));
        $('#edit_category_status').val($(this).data('status'));
        $('#editCategoryModal').modal('show');
    });

    // Delete button
    $('.delete-btn').click(function() {
        if (confirm('Are you sure you want to delete this category?')) {
            var categoryId = $(this).data('id');
            var row = $(this).closest('tr');
            $.post('<?= APP_URL ?>/index.php?page=categories&action=delete', {
                category_id: categoryId
            }, function(response) {
                if (response.status == 1) {
                    row.fadeOut();
                } else {
                    alert(response.error || 'Failed to delete category');
                }
            }, 'json');
        }
    });
});
</script>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>
