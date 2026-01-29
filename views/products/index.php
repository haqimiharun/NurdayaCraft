<?php
/**
 * Products Admin View
 */

include __DIR__ . '/../layouts/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Products</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table" id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id'] ?></td>
                    <td>
                        <?php if (!empty($product['product_image'])): ?>
                            <img src="<?= upload('products/' . $product['product_image']) ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            <img src="<?= asset('images/image-not-found-icon.png') ?>" width="50" height="50">
                        <?php endif; ?>
                    </td>
                    <td><?= e($product['product_name']) ?></td>
                    <td><?= e($product['category_name']) ?></td>
                    <td><?= formatPrice($product['product_price']) ?></td>
                    <td><?= $product['product_qty'] ?></td>
                    <td>
                        <?php if ($product['product_status'] === 'Y'): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="<?= $product['product_id'] ?>">Edit</button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $product['product_id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= APP_URL ?>/index.php?page=products&action=store" method="POST" enctype="multipart/form-data">
                <?= csrfField() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="product_category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>"><?= e($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="product_desc" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" name="product_price" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="product_qty" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="product_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="product_status">
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= APP_URL ?>/index.php?page=products&action=update" method="POST">
                <?= csrfField() ?>
                <input type="hidden" name="edit_product_id" id="edit_product_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="edit_product_category" id="edit_product_category" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>"><?= e($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="edit_product_name" id="edit_product_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="edit_product_desc" id="edit_product_desc" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" name="edit_product_price" id="edit_product_price" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="edit_product_qty" id="edit_product_qty" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="edit_product_status" id="edit_product_status">
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#productsTable').DataTable();

    // Edit button
    $('.edit-btn').click(function() {
        var productId = $(this).data('id');
        $.post('<?= APP_URL ?>/index.php?page=products&action=getEditData', {
            product_id: productId
        }, function(data) {
            $('#edit_product_id').val(data.product_id);
            $('#edit_product_name').val(data.product_name);
            $('#edit_product_desc').val(data.product_description);
            $('#edit_product_category').val(data.category_id);
            $('#edit_product_price').val(data.product_price);
            $('#edit_product_qty').val(data.product_qty);
            $('#edit_product_status').val(data.product_status);
            $('#editProductModal').modal('show');
        }, 'json');
    });

    // Delete button
    $('.delete-btn').click(function() {
        if (confirm('Are you sure you want to delete this product?')) {
            var productId = $(this).data('id');
            var row = $(this).closest('tr');
            $.post('<?= APP_URL ?>/index.php?page=products&action=delete', {
                product_id: productId
            }, function(response) {
                if (response.status == 1) {
                    row.fadeOut();
                } else {
                    alert('Failed to delete product');
                }
            }, 'json');
        }
    });
});
</script>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>
