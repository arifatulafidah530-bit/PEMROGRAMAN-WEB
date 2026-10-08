<?php

require_once __DIR__ . '/../includes/auth.php';
csrf_verify();

require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$kode = trim($_POST['kode'] ?? '');
$id_pelanggan = trim($_POST['id_pelanggan'] ?? '');
$jenis_layanan = trim($_POST['jenis_layanan'] ?? '');
$berat = trim($_POST['berat'] ?? '');
$total_biaya = trim($_POST['total_biaya'] ?? '');
$dibayar = trim($_POST['dibayar'] ?? '0');
$status = trim($_POST['status'] ?? '');
$pelanggan_tidak_ditemukan = false;

if ($kode === '') {
    do {
        $kode = 'TRX-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
        $cekKodeOtomatis = $koneksi->prepare('SELECT COUNT(*) FROM transaksi WHERE kode = :kode');
        $cekKodeOtomatis->execute([':kode' => $kode]);
    } while ((int) $cekKodeOtomatis->fetchColumn() > 0);
}

if ($id_pelanggan !== '' && !ctype_digit($id_pelanggan)) {
    $namaPelanggan = preg_replace('/\s+/', ' ', $id_pelanggan);
    $stmtPelanggan = $koneksi->prepare('SELECT id_pelanggan FROM pelanggan WHERE LOWER(TRIM(nama)) = LOWER(TRIM(:nama)) LIMIT 1');
    $stmtPelanggan->execute([':nama' => $namaPelanggan]);
    $id_pelangganDitemukan = $stmtPelanggan->fetchColumn();
    $id_pelanggan = (string) ($id_pelangganDitemukan ?: '');
    $pelanggan_tidak_ditemukan = $id_pelanggan === '';
}

if ($pelanggan_tidak_ditemukan) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Nama pelanggan tidak ditemukan. Pilih atau ketik nama pelanggan yang sudah terdaftar.'];
    header('Location: tambah.php');
    exit;
}

if (
    $kode === '' ||
    $id_pelanggan === '' ||
    $jenis_layanan === '' ||
    $berat === '' ||
    $status === ''
) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Silakan lengkapi semua data transaksi.'
    ];

    header('Location: tambah.php');
    exit;
}

if (!is_numeric($berat) || $berat <= 0) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Berat laundry harus lebih dari 0.'
    ];

    header('Location: tambah.php');
    exit;
}

$stmtTarif = $koneksi->prepare('SELECT harga_per_kg FROM tarif_layanan WHERE nama = :nama LIMIT 1');
$stmtTarif->execute([':nama' => $jenis_layanan]);
$hargaPerKg = $stmtTarif->fetchColumn();
if ($hargaPerKg === false) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Tarif layanan tidak ditemukan.'];
    header('Location: tambah.php');
    exit;
}
$total_biaya = (string) ceil((float) $berat * (int) $hargaPerKg);

if (!is_numeric($total_biaya) || $total_biaya < 0) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Total biaya tidak valid.'
    ];

    header('Location: tambah.php');
    exit;
}

if (!is_numeric($dibayar) || $dibayar < 0 || $dibayar > $total_biaya) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Nominal pembayaran tidak valid.'];
    header('Location: tambah.php');
    exit;
}
$statusPembayaran = (float) $dibayar >= (float) $total_biaya ? 'Lunas' : ((float) $dibayar > 0 ? 'DP' : 'Belum Lunas');

$cekKode = $koneksi->prepare('SELECT COUNT(*) FROM transaksi WHERE kode = :kode');
$cekKode->execute([':kode' => $kode]);
if ((int) $cekKode->fetchColumn() > 0) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Kode transaksi sudah digunakan.'];
    header('Location: tambah.php');
    exit;
}

try {

    $stmt = $koneksi->prepare("
        INSERT INTO transaksi
        (id_pelanggan, kode, layanan, berat, total_biaya, status, dibayar, status_pembayaran)
        VALUES
        (:id_pelanggan, :kode, :layanan, :berat, :total_biaya, :status, :dibayar, :status_pembayaran)
    ");

    $stmt->execute([
        ':id_pelanggan' => $id_pelanggan,
        ':kode' => $kode,
        ':layanan' => $jenis_layanan,
        ':berat' => $berat,
        ':total_biaya' => $total_biaya,
        ':status' => $status,
        ':dibayar' => $dibayar,
        ':status_pembayaran' => $statusPembayaran
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Data transaksi berhasil ditambahkan.'
    ];

} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Data transaksi gagal ditambahkan.'
    ];

}

header('Location: list.php');
exit;