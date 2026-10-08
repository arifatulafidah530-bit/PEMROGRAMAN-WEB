<?php
require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = app_base_path();
$active = $active ?? '';
$sudahLogin = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LaundryKu' ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link
        rel="stylesheet"
        href="<?= $base ?>/assets/css/style.css">

</head>
<body>
<header>

    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-basket-fill"></i>
        </div>
        <div>

            <h1>LaundryKu</h1>
            <p>Layanan Laundry</p>

        </div>
    </div>
    <input type="checkbox" id="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">
        <i class="bi bi-list"></i>
    </label>
    <nav>
        <a
            href="<?= $base ?>/index.php"
            class="<?= $active === 'beranda' ? 'active' : '' ?>">
            <i class="bi bi-house-door-fill"></i>
            Beranda
        </a>

        <?php if ($sudahLogin): ?>
            <a
                href="<?= $base ?>/pelanggan/list.php"
                class="<?= $active === 'pelanggan' ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i>
                Pelanggan
            </a>

            <a
                href="<?= $base ?>/pelanggan/tambah.php"
                class="<?= $active === 'tambah-pelanggan' ? 'active' : '' ?>">
                <i class="bi bi-person-plus-fill"></i>
                Tambah Pelanggan
            </a>

            <a
                href="<?= $base ?>/transaksi/list.php"
                class="<?= $active === 'transaksi' ? 'active' : '' ?>">
                <i class="bi bi-receipt"></i>
                Transaksi
            </a>

            <a
                href="<?= $base ?>/pengambilan/tambah.php"
                class="<?= $active === 'pengambilan-baru' ? 'active' : '' ?>">
                <i class="bi bi-plus-circle-fill"></i>
                Penerimaan
            </a>

            <a
                href="<?= $base ?>/pengambilan/kembali.php"
                class="<?= $active === 'pengambilan' ? 'active' : '' ?>">
                <i class="bi bi-bag-check-fill"></i>
                Pengambilan
            </a>

            <a
                href="<?= $base ?>/pengambilan/riwayat.php"
                class="<?= $active === 'riwayat' ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i>
                Riwayat
            </a>

            <a class="user-status <?= $active === 'profil' ? 'active' : '' ?>" href="<?= $base ?>/profil.php" title="Lihat dan ubah profil">
                <i class="bi bi-person-circle"></i>
                <?= e($_SESSION['nama_user']) ?>
            </a>

            <button type="button" class="nav-logout-button" data-logout-open>
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
            </button>
        <?php else: ?>
            <a
                href="<?= $base ?>/login.php"
                class="<?= $active === 'login' ? 'active' : '' ?>">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </a>

            <a
                href="<?= $base ?>/register.php"
                class="<?= $active === 'register' ? 'active' : '' ?>">
                <i class="bi bi-person-plus-fill"></i>
                Registrasi
            </a>
        <?php endif; ?>
    </nav>
</header>
<?php if ($sudahLogin): ?>
    <dialog class="logout-dialog" data-logout-dialog aria-labelledby="logout-dialog-title" aria-describedby="logout-dialog-description">
        <div class="logout-dialog-icon" aria-hidden="true">
            <i class="bi bi-box-arrow-right"></i>
        </div>
        <h2 id="logout-dialog-title">Yakin ingin logout?</h2>
        <p id="logout-dialog-description">Anda akan keluar dari akun LaundryKu.</p>
        <form action="<?= $base ?>/logout.php" method="POST" class="logout-dialog-actions">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <button type="button" class="logout-cancel" data-logout-cancel>Batal</button>
            <button type="submit" class="logout-confirm">Ya, Logout</button>
        </form>
    </dialog>
<?php endif; ?>