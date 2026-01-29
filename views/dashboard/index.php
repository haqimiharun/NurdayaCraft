<?php
/**
 * Dashboard Admin View
 */

include __DIR__ . '/../layouts/admin-header.php';
?>

<h1 class="mb-4">Dashboard</h1>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-main">
            <div class="card-body">
                <h3><?= $stats['total_products'] ?></h3>
                <p class="mb-0">Total Products</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-lighter">
            <div class="card-body">
                <h3><?= $stats['total_orders'] ?></h3>
                <p class="mb-0">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-main">
            <div class="card-body">
                <h3><?= formatPrice($stats['total_revenue']) ?></h3>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4><?= $stats['total_categories'] ?></h4>
                <p class="mb-0 text-muted">Categories</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4><?= $stats['pending_orders'] ?></h4>
                <p class="mb-0 text-muted">Pending Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4><?= $stats['total_users'] ?></h4>
                <p class="mb-0 text-muted">Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h4><?= $stats['total_orders'] - $stats['pending_orders'] ?></h4>
                <p class="mb-0 text-muted">Completed Orders</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="<?= APP_URL ?>/index.php?page=orders" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td>#<?= $order['order_id'] ?></td>
                            <td><?= e($order['product_name']) ?></td>
                            <td><?= formatPrice($order['subtotal']) ?></td>
                            <td>
                                <?php if ($order['status'] === 'P'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($order['status'] === 'Y'): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= e($order['status']) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Top Products</h5>
            </div>
            <div class="card-body">
                <?php if (empty($topProducts)): ?>
                    <p class="text-muted">No sales data yet</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($topProducts as $product): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= e($product['product_name']) ?>
                            <span class="badge bg-primary rounded-pill"><?= $product['total_sold'] ?> sold</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>
