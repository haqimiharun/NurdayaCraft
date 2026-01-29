    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="social-bar bg-main">
            Follow Us:
            <a href="https://www.facebook.com/Zadagiftshop"><img src="<?= asset('images/fbicon.png') ?>" alt="Facebook"></a>
            <a href="https://www.instagram.com/nurdayacraft/"><img src="<?= asset('images/igicon.png') ?>" alt="Instagram"></a>
        </div>

        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Connect with Us</h4>
                        <p>Subscribe to our newsletter</p>
                        <form action="#" method="POST" class="mt-3">
                            <div class="mb-2">
                                <input type="email" name="email" placeholder="Email Address" class="form-control subscribe-border subscribe-input">
                            </div>
                            <button type="submit" class="btn subscribe-btn subscribe-border">Subscribe</button>
                        </form>
                    </div>

                    <div class="col-md-4 text-center">
                        <div class="footer-brand">NurDayah Store</div>
                        <p class="footer-tagline">Malaysian Crafter CLIPART & VECTOR ARTWORK</p>
                    </div>

                    <div class="col-md-4 footer-links">
                        <h4>Customer Care</h4>
                        <a href="#">Contact Us</a>
                        <a href="#">Return Policy</a>
                        <a href="#">Order Tracking</a>
                        <a href="#">Find Us</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center py-3 bg-main">
            <small>&copy; <?= date('Y') ?> NurDaya Store. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
