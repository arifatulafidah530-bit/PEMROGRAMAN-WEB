<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$jenis_layanan = trim($_POST['jenis_layanan'] ?? '');

if ($nama === '' || $no_hp === '' || $alamat === '' || $jenis_layanan === '') {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Silakan lengkapi semua data pelanggan.'
    ];

    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['pelanggan'])) {
    $_SESSION['pelanggan'] = [];
}

$_SESSION['pelanggan'][] = [
    'nama' => $nama,
    'no_hp' => $no_hp,
    'alamat' => $alamat,
    'jenis_layanan' => $jenis_layanan
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data pelanggan berhasil ditambahkan.'
];

header('Location: list.php');
exit;