<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$projectName = basename(str_replace('\\', '/', dirname(__DIR__)));
$base = str_contains($scriptPath, '/' . $projectName . '/') ? '/' . $projectName : '';
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

            <span class="user-status">
                <i class="bi bi-person-circle"></i>
                <?= htmlspecialchars($_SESSION['nama_user']) ?>
            </span>

            <a href="<?= $base ?>/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
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