<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$kode = trim($_POST['kode'] ?? '');
$nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
$jenis_layanan = trim($_POST['jenis_layanan'] ?? '');
$berat = trim($_POST['berat'] ?? '');
$total_biaya = trim($_POST['total_biaya'] ?? '');
$status = trim($_POST['status'] ?? '');

if (
    $kode === '' ||
    $nama_pelanggan === '' ||
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

if (!isset($_SESSION['transaksi'])) {
    $_SESSION['transaksi'] = [];
}

$_SESSION['transaksi'][] = [
    'kode' => $kode,
    'pelanggan' => $nama_pelanggan,
    'layanan' => $jenis_layanan,
    'berat' => $berat,
    'total' => $total_biaya,
    'status' => $status
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data transaksi berhasil ditambahkan.'
];

header('Location: list.php');
exit;