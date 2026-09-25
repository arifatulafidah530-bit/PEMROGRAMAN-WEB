<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id_transaksi'] ?? '';
$kode = trim($_POST['kode'] ?? '');
$id_pelanggan = trim($_POST['id_pelanggan'] ?? '');
$layanan = trim($_POST['jenis_layanan'] ?? '');
$berat = trim($_POST['berat'] ?? '');
$total_biaya = trim($_POST['total_biaya'] ?? '');
$status = trim($_POST['status'] ?? '');

if ($id === '' || !is_numeric($id) || $kode === '' || $id_pelanggan === '' || $layanan === '' || $berat === '' || $total_biaya === '' || $status === '' || !is_numeric($berat) || $berat <= 0 || !is_numeric($total_biaya) || $total_biaya < 0) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data transaksi tidak lengkap atau tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $koneksi->prepare('UPDATE transaksi SET id_pelanggan = :id_pelanggan, kode = :kode, layanan = :layanan, berat = :berat, total_biaya = :total_biaya, status = :status WHERE id_transaksi = :id');
    $stmt->execute([':id_pelanggan' => $id_pelanggan, ':kode' => $kode, ':layanan' => $layanan, ':berat' => $berat, ':total_biaya' => $total_biaya, ':status' => $status, ':id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data transaksi berhasil diperbarui.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data transaksi gagal diperbarui.'];
}

header('Location: list.php');
exit;
