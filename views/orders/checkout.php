<?php
/**
 * Checkout View
 */

$pageTitle = 'Checkout - Nurdaya Store';
include __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>

    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-4 order-md-2 mb-4">
            <div class="card">
                <div class="card-header bg-main">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <?php if (!empty($product['product_image'])): ?>
                            <img src="<?= upload('products/' . $product['product_image']) ?>" width="80" height="80" style="object-fit: cover; border-radius: 5px;" class="me-3">
                        <?php endif; ?>
                        <div>
                            <h6><?= e($product['product_name']) ?></h6>
                            <p class="mb-0"><?= formatPrice($product['product_price']) ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Unit Price</span>
                        <span id="unitPrice"><?= formatPrice($product['product_price']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Quantity</span>
                        <span id="displayQty">1</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong id="totalPrice"><?= formatPrice($product['product_price']) ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-md-8 order-md-1">
            <div class="card">
                <div class="card-body">
                    <form action="<?= APP_URL ?>/index.php?page=checkout&action=process" method="POST" data-validate>
                        <?= csrfField() ?>
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                        <h5 class="mb-3">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required
                                       value="<?= Auth::check() ? e(Session::get('user_email', '')) : '' ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone_number" required>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Shipping Address</h5>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Postcode</label>
                                <input type="text" class="form-control" name="postcode" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <select class="form-control" name="states" required>
                                    <option value="">Select State</option>
                                    <option value="Johor">Johor</option>
                                    <option value="Kedah">Kedah</option>
                                    <option value="Kelantan">Kelantan</option>
                                    <option value="Melaka">Melaka</option>
                                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Pahang">Pahang</option>
                                    <option value="Perak">Perak</option>
                                    <option value="Perlis">Perlis</option>
                                    <option value="Pulau Pinang">Pulau Pinang</option>
                                    <option value="Sabah">Sabah</option>
                                    <option value="Sarawak">Sarawak</option>
                                    <option value="Selangor">Selangor</option>
                                    <option value="Terengganu">Terengganu</option>
                                    <option value="W.P. Kuala Lumpur">W.P. Kuala Lumpur</option>
                                    <option value="W.P. Labuan">W.P. Labuan</option>
                                    <option value="W.P. Putrajaya">W.P. Putrajaya</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Order Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="qty" id="qty"
                                   value="1" min="1" max="<?= $product['product_qty'] ?>" required>
                            <small class="text-muted"><?= $product['product_qty'] ?> available</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var unitPrice = <?= $product['product_price'] ?>;

    $('#qty').on('change', function() {
        var qty = parseInt($(this).val()) || 1;
        var total = unitPrice * qty;
        $('#displayQty').text(qty);
        $('#totalPrice').text('RM ' + total.toFixed(2));
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
