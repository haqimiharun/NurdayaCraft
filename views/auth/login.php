<?php
/**
 * Login Page View
 */

$pageTitle = 'Login - Nurdaya Store';
include __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Login</h2>

                    <?php if ($error ?? false): ?>
                        <div class="alert alert-danger">Wrong username or password</div>
                    <?php endif; ?>

                    <form action="<?= APP_URL ?>/index.php?page=login&action=process" method="POST" data-validate>
                        <?= csrfField() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-secondary">Login</button>
                            <a href="<?= APP_URL ?>/index.php?page=register" class="btn btn-outline">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
