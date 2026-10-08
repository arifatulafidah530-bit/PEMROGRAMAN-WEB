<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/koneksi.php';

$stmt = $koneksi->prepare('SELECT username, nama, role FROM users WHERE id_user = :id_user');
$stmt->execute([':id_user' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

$title = 'Profil Akun | LaundryKu';
$active = 'profil';

include __DIR__ . '/includes/header.php';
?>

<main>
    <div class="page-header">
        <h2>Profil Akun</h2>
        <p>Lihat informasi akun dan ubah nama atau password.</p>
    </div>

    <div class="content-card">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">
                <?= e($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_profil.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" value="<?= e($user['username']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" value="<?= e($user['role']) ?>" readonly>
                </div>

                <div class="form-group full">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($user['nama']) ?>" required>
                </div>

                <div class="form-group full">
                    <label for="current_password">Password saat ini</label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">Password baru</label>
                    <input type="password" id="new_password" name="new_password" minlength="8" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi password baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="8" autocomplete="new-password">
                </div>
            </div>

            <p class="form-help">Kosongkan kedua kolom password baru jika hanya ingin mengubah nama. Password baru minimal 8 karakter.</p>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-save-fill"></i>
                    Simpan Profil
                </button>
                <a href="index.php" class="btn-reset">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
