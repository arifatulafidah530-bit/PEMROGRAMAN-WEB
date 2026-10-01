<?php
$title = 'Registrasi | LaundryKu';
$active = 'register';
include __DIR__ . '/includes/header.php';
?>
<main>
    <div class="page-header">
        <h2>Registrasi Petugas</h2>
        <p>Buat akun untuk mengelola data LaundryKu.</p>
    </div>

    <div class="content-card auth-card">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
                <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_register.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" minlength="6" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-person-plus-fill"></i>
                    Daftar
                </button>
                <a href="login.php" class="btn-reset">Kembali ke Login</a>
            </div>
        </form>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
