<?php
/**
 * My Orders View (Customer)
 */

$pageTitle = 'My Orders - Nurdaya Store';
include __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">My Orders</h1>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            You haven't placed any orders yet.
            <a href="<?= APP_URL ?>">Start shopping</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($orders as $order): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Order #<?= $order['order_id'] ?></span>
                        <?php if ($order['status'] === 'P'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php elseif ($order['status'] === 'Y'): ?>
                            <span class="badge bg-success">Completed</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= e($order['status']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <?php if (!empty($order['product_image'])): ?>
                                <img src="<?= upload('products/' . $order['product_image']) ?>" width="80" height="80"
                                     style="object-fit: cover; border-radius: 5px;" class="me-3">
                            <?php endif; ?>
                            <div>
                                <h6><?= e($order['product_name']) ?></h6>
                                <p class="mb-1">Quantity: <?= $order['product_qty'] ?></p>
                                <p class="mb-1"><strong>Total: <?= formatPrice($order['subtotal']) ?></strong></p>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-1"><small><strong>Tracking:</strong> <?= e($order['tracking_no']) ?></small></p>
                        <p class="mb-0"><small><strong>Shipping to:</strong> <?= e($order['city']) ?>, <?= e($order['states']) ?></small></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
