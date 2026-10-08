<?php
$title = 'Login | LaundryKu';
$active = 'login';
include __DIR__ . '/includes/header.php';
?>
<main>
    <div class="page-header">
        <h2>Login Petugas</h2>
        <p>Masuk untuk mengelola data LaundryKu.</p>
    </div>

    <div class="content-card auth-card">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">
                <?= e($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>
                <a href="register.php" class="btn-reset">Daftar di sini</a>
            </div>
        </form>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
