<?php
require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
if ($base === '/') {
    $base = '';
}
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
        <div class="brand-icon brand-mark">
            <i class="bi bi-basket2-fill"></i>
            <i class="bi bi-droplet-fill brand-drop"></i>
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

            <details class="nav-dropdown" <?= in_array($active, ['pengambilan-baru', 'pengambilan', 'riwayat'], true) ? 'open' : '' ?>>
                <summary>
                    <i class="bi bi-bag-check-fill"></i>
                    Operasional
                    <i class="bi bi-chevron-down"></i>
                </summary>
                <div class="nav-dropdown-menu">
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
                </div>
            </details>

            <span class="user-status">
                <i class="bi bi-person-circle"></i>
                <?= e($_SESSION['nama_user']) ?>
            </span>

            <form action="<?= $base ?>/logout.php" method="POST" class="nav-logout">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
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