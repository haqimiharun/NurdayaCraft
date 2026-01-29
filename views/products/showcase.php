<?php
/**
 * Product Showcase View
 */

$pageTitle = e($product['product_name']) . ' - Nurdaya Store';
include __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <?php if (!empty($product['product_image'])): ?>
                <img src="<?= upload('products/' . $product['product_image']) ?>" class="img-fluid rounded" alt="<?= e($product['product_name']) ?>">
            <?php else: ?>
                <img src="<?= asset('images/image-not-found-icon.png') ?>" class="img-fluid rounded" alt="No image">
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= APP_URL ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= APP_URL ?>/#product"><?= e($product['category_name']) ?></a></li>
                    <li class="breadcrumb-item active"><?= e($product['product_name']) ?></li>
                </ol>
            </nav>

            <h1 class="mb-3"><?= e($product['product_name']) ?></h1>
            <p class="text-muted mb-3">Category: <?= e($product['category_name']) ?></p>

            <h2 class="text-accent mb-4"><?= formatPrice($product['product_price']) ?></h2>

            <p class="mb-4"><?= nl2br(e($product['product_description'])) ?></p>

            <p class="mb-4">
                <strong>Availability:</strong>
                <?php if ($product['product_qty'] > 0): ?>
                    <span class="text-success"><?= $product['product_qty'] ?> in stock</span>
                <?php else: ?>
                    <span class="text-danger">Out of stock</span>
                <?php endif; ?>
            </p>

            <?php if ($product['product_qty'] > 0): ?>
                <a href="<?= APP_URL ?>/index.php?page=checkout&product=<?= $product['product_id'] ?>" class="btn btn-primary btn-lg">
                    Buy Now
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($relatedProducts)): ?>
    <!-- Related Products -->
    <div class="mt-5">
        <h3 class="mb-4">Related Products</h3>
        <div class="row">
            <?php foreach ($relatedProducts as $related): ?>
            <div class="col-md-3">
                <div class="product-container">
                    <?php if (!empty($related['product_image'])): ?>
                        <a href="<?= APP_URL ?>/index.php?page=showcase&product=<?= $related['product_id'] ?>">
                            <img src="<?= upload('products/' . $related['product_image']) ?>" height="150" style="border-radius: 10px;" alt="<?= e($related['product_name']) ?>">
                        </a>
                    <?php else: ?>
                        <a href="<?= APP_URL ?>/index.php?page=showcase&product=<?= $related['product_id'] ?>">
                            <img src="<?= asset('images/image-not-found-icon.png') ?>" height="150" style="border-radius: 10px;" alt="No image">
                        </a>
                    <?php endif; ?>
                    <div class="product-info">
                        <p class="product-name"><?= e($related['product_name']) ?></p>
                        <p class="product-price"><?= formatPrice($related['product_price']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
