<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';
if ($id === '' || !ctype_digit((string) $id)) {
    header('Location: list.php');
    exit;
}

$stmt = $koneksi->prepare('SELECT transaksi.*, pelanggan.nama, pelanggan.no_hp, pelanggan.alamat FROM transaksi JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan WHERE transaksi.id_transaksi = :id');
$stmt->execute([':id' => $id]);
$transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaksi) {
    header('Location: list.php');
    exit;
}

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk <?= $escape($transaksi['kode']) ?> | LaundryKu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="receipt-page">
    <main class="receipt">
        <div class="receipt-header">
            <div class="brand-icon"><i class="bi bi-basket-fill"></i></div>
            <div>
                <h1>LaundryKu</h1>
                <p>Bukti Penerimaan Laundry</p>
            </div>
        </div>
        <div class="receipt-code">
            <span>Kode Transaksi</span>
            <strong><?= $escape($transaksi['kode']) ?></strong>
        </div>
        <dl class="receipt-details">
            <div><dt>Pelanggan</dt><dd><?= $escape($transaksi['nama']) ?></dd></div>
            <div><dt>No. HP</dt><dd><?= $escape($transaksi['no_hp']) ?></dd></div>
            <div><dt>Layanan</dt><dd><?= $escape($transaksi['layanan']) ?></dd></div>
            <div><dt>Berat</dt><dd><?= $escape($transaksi['berat']) ?> kg</dd></div>
            <div><dt>Status</dt><dd><?= $escape($transaksi['status']) ?></dd></div>
            <div><dt>Dibayar</dt><dd>Rp<?= number_format((int) $transaksi['dibayar'], 0, ',', '.') ?></dd></div>
            <div><dt>Pembayaran</dt><dd><?= $escape($transaksi['status_pembayaran']) ?></dd></div>
        </dl>
        <div class="receipt-total">
            <span>Total Biaya</span>
            <strong>Rp<?= number_format((int) $transaksi['total_biaya'], 0, ',', '.') ?></strong>
        </div>
        <p class="receipt-note">Simpan struk ini sebagai bukti penerimaan laundry.</p>
        <button type="button" class="btn-submit no-print" onclick="window.print()"><i class="bi bi-printer-fill"></i> Cetak Struk</button>
    </main>
</body>
</html>
