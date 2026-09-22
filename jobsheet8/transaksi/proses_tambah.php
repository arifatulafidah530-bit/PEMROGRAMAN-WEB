<?php

session_start();

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
$status = trim($_POST['status'] ?? '');

if (
    $kode === '' ||
    $id_pelanggan === '' ||
    $jenis_layanan === '' ||
    $berat === '' ||
    $total_biaya === '' ||
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

if (!is_numeric($total_biaya) || $total_biaya < 0) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Total biaya tidak valid.'
    ];

    header('Location: tambah.php');
    exit;
}

try {

    $stmt = $koneksi->prepare("
        INSERT INTO transaksi
        (id_pelanggan, kode, layanan, berat, total_biaya, status)
        VALUES
        (:id_pelanggan, :kode, :layanan, :berat, :total_biaya, :status)
    ");

    $stmt->execute([
        ':id_pelanggan' => $id_pelanggan,
        ':kode' => $kode,
        ':layanan' => $jenis_layanan,
        ':berat' => $berat,
        ':total_biaya' => $total_biaya,
        ':status' => $status
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