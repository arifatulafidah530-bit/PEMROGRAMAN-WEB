<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

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

try {

    $stmt = $koneksi->prepare("
        INSERT INTO pelanggan (nama, no_hp, alamat, jenis_layanan)
        VALUES (:nama, :no_hp, :alamat, :jenis_layanan)
    ");

    $stmt->execute([
        ':nama' => $nama,
        ':no_hp' => $no_hp,
        ':alamat' => $alamat,
        ':jenis_layanan' => $jenis_layanan
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Data pelanggan berhasil ditambahkan.'
    ];

} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Data pelanggan gagal ditambahkan.'
    ];

}

header('Location: list.php');
exit;