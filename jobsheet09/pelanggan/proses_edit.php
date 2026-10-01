<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id_pelanggan'] ?? '';
$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$jenis_layanan = trim($_POST['jenis_layanan'] ?? '');

if (
    $id === '' ||
    !is_numeric($id) ||
    $nama === '' ||
    $no_hp === '' ||
    $alamat === '' ||
    $jenis_layanan === ''
) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Silakan lengkapi semua data pelanggan.'
    ];

    header('Location: list.php');
    exit;
}

try {

    $stmt = $koneksi->prepare("
        UPDATE pelanggan
        SET
            nama = :nama,
            no_hp = :no_hp,
            alamat = :alamat,
            jenis_layanan = :jenis_layanan
        WHERE id_pelanggan = :id
    ");

    $stmt->execute([
        ':nama' => $nama,
        ':no_hp' => $no_hp,
        ':alamat' => $alamat,
        ':jenis_layanan' => $jenis_layanan,
        ':id' => $id
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Data pelanggan berhasil diperbarui.'
    ];

} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Data pelanggan gagal diperbarui.'
    ];

}

header('Location: list.php');
exit;