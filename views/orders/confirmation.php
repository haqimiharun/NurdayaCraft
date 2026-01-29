<?php
/**
 * Order Confirmation View
 */

$pageTitle = 'Order Confirmed - Nurdaya Store';
include __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
        </div>
        <h1 class="text-success">Order Confirmed!</h1>
        <p class="lead">Thank you for your purchase</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-main">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Order ID:</strong> #<?= $order['order_id'] ?></p>
                            <p><strong>Tracking Number:</strong> <?= e($order['tracking_no']) ?></p>
                            <p><strong>Status:</strong>
                                <span class="badge bg-warning">Pending</span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Email:</strong> <?= e($order['email']) ?></p>
                            <p><strong>Phone:</strong> <?= e($order['phone_number']) ?></p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex align-items-center mb-4">
                        <?php if (!empty($order['product_image'])): ?>
                            <img src="<?= upload('products/' . $order['product_image']) ?>" width="100" height="100" style="object-fit: cover; border-radius: 10px;" class="me-3">
                        <?php endif; ?>
                        <div>
                            <h5><?= e($order['product_name']) ?></h5>
                            <p class="mb-0">Quantity: <?= $order['product_qty'] ?></p>
                            <p class="mb-0">Price: <?= formatPrice($order['product_price']) ?></p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Shipping Address</h6>
                            <p>
                                <?= e($order['address']) ?><br>
                                <?= e($order['city']) ?>, <?= e($order['postcode']) ?><br>
                                <?= e($order['states']) ?>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4>Total: <?= formatPrice($order['subtotal']) ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= APP_URL ?>" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
