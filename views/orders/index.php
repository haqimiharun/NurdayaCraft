<?php
/**
 * Orders Admin View
 */

include __DIR__ . '/../layouts/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Orders</h1>
</div>

<div class="card">
    <div class="card-body">
        <table class="table" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Customer</th>
                    <th>Tracking No</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['order_id'] ?></td>
                    <td>
                        <?php if (!empty($order['product_image'])): ?>
                            <img src="<?= upload('products/' . $order['product_image']) ?>" width="40" height="40" style="object-fit: cover; border-radius: 5px;">
                        <?php endif; ?>
                        <?= e($order['product_name']) ?>
                    </td>
                    <td><?= $order['product_qty'] ?></td>
                    <td><?= formatPrice($order['subtotal']) ?></td>
                    <td><?= e($order['email']) ?></td>
                    <td><?= e($order['tracking_no']) ?></td>
                    <td>
                        <?php if ($order['status'] === 'P'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php elseif ($order['status'] === 'Y'): ?>
                            <span class="badge bg-success">Completed</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= e($order['status']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary view-btn"
                                data-id="<?= $order['order_id'] ?>"
                                data-tracking="<?= e($order['tracking_no']) ?>"
                                data-status="<?= $order['status'] ?>">
                            View
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View/Edit Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= APP_URL ?>/index.php?page=orders&action=updateStatus" method="POST">
                <?= csrfField() ?>
                <input type="hidden" name="order_id" id="modal_order_id">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="orderDetails"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" name="tracking_no" id="modal_tracking_no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status" id="modal_status">
                                <option value="P">Pending</option>
                                <option value="Y">Completed</option>
                                <option value="C">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#ordersTable').DataTable({
        order: [[0, 'desc']]
    });

    // View button
    $('.view-btn').click(function() {
        var orderId = $(this).data('id');
        $('#modal_order_id').val(orderId);
        $('#modal_tracking_no').val($(this).data('tracking'));
        $('#modal_status').val($(this).data('status'));

        // Load order details
        $.post('<?= APP_URL ?>/index.php?page=orders&action=getDetails', {
            order_id: orderId
        }, function(data) {
            var html = '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<p><strong>Product:</strong> ' + data.product_name + '</p>';
            html += '<p><strong>Quantity:</strong> ' + data.product_qty + '</p>';
            html += '<p><strong>Subtotal:</strong> RM ' + parseFloat(data.subtotal).toFixed(2) + '</p>';
            html += '</div>';
            html += '<div class="col-md-6">';
            html += '<p><strong>Email:</strong> ' + data.email + '</p>';
            html += '<p><strong>Phone:</strong> ' + data.phone_number + '</p>';
            html += '<p><strong>Address:</strong> ' + data.address + ', ' + data.city + ', ' + data.postcode + ', ' + data.states + '</p>';
            html += '</div>';
            html += '</div>';
            $('#orderDetails').html(html);
            $('#orderModal').modal('show');
        }, 'json');
    });
});
</script>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>
