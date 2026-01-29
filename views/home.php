<?php
/**
 * Home Page View
 */

$pageTitle = 'Nurdaya Store - Malaysian Craft Products';
include __DIR__ . '/layouts/header.php';
?>

<!-- Hero Section -->
<section class="hero-section bg-lighter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="<?= asset('images/mainproduct.png') ?>" class="img-fluid" alt="Featured Product">
            </div>
            <div class="col-md-6">
                <div class="hero-discount">40% Discount</div>
                <h1 class="hero-title">New Year Collection</h1>
                <p class="hero-subtitle">Art is never finished, only abandoned</p>
                <a href="#product" class="btn btn-primary" style="border-radius: 42px; padding: 12px 30px;">Shop Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Products by Category -->
<?php foreach ($productsByCategory as $data): ?>
<section id="product" class="section">
    <div class="container">
        <h2 class="section-title"><?= e($data['category']['category_name']) ?></h2>
    </div>

    <div class="products-grid">
        <?php foreach ($data['products'] as $product): ?>
        <div class="product-container">
            <?php if (!empty($product['product_image'])): ?>
                <a href="<?= APP_URL ?>/index.php?page=showcase&product=<?= $product['product_id'] ?>">
                    <img src="<?= upload('products/' . $product['product_image']) ?>" height="250" style="border-radius: 10px;" alt="<?= e($product['product_name']) ?>">
                </a>
            <?php else: ?>
                <a href="<?= APP_URL ?>/index.php?page=showcase&product=<?= $product['product_id'] ?>">
                    <img src="<?= asset('images/image-not-found-icon.png') ?>" height="250" style="border-radius: 10px;" alt="No image">
                </a>
            <?php endif; ?>

            <div class="product-info">
                <p class="product-name"><?= e($product['product_name']) ?></p>
                <p class="product-price"><?= formatPrice($product['product_price']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>

<div style="height: 100px;"></div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
