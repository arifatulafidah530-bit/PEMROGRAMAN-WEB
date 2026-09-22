<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
if ($base === '/') {
    $base = '';
}
$active = $active ?? '';
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
    </nav>
</header>