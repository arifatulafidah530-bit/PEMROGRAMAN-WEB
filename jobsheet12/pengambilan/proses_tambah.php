<?php
require_once __DIR__ . '/../includes/auth.php';
csrf_verify();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: tambah.php'); exit; }
$idPelanggan = $_POST['id_pelanggan'] ?? '';
$kode = trim($_POST['kode'] ?? '');
$layanan = trim($_POST['layanan'] ?? '');
$berat = $_POST['berat'] ?? '';
$totalBiaya = $_POST['total_biaya'] ?? '';

if ($idPelanggan !== '' && !ctype_digit($idPelanggan)) {
    $stmtPelanggan = $koneksi->prepare('SELECT id_pelanggan FROM pelanggan WHERE LOWER(nama) = LOWER(:nama) LIMIT 1');
    $stmtPelanggan->execute([':nama' => $idPelanggan]);
    $idPelanggan = (string) ($stmtPelanggan->fetchColumn() ?: '');
}

if ($idPelanggan === '' || $kode === '' || $layanan === '' || !is_numeric($berat) || $berat <= 0 || !is_numeric($totalBiaya) || $totalBiaya < 0) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data penerimaan belum lengkap atau tidak valid.'];
    header('Location: tambah.php'); exit;
}

try {
    $koneksi->beginTransaction();
    $pelanggan = $koneksi->prepare('SELECT id_pelanggan FROM pelanggan WHERE id_pelanggan = :id FOR UPDATE');
    $pelanggan->execute([':id' => $idPelanggan]);
    if (!$pelanggan->fetch()) { throw new RuntimeException('Pelanggan tidak ditemukan.'); }

    $transaksi = $koneksi->prepare('INSERT INTO transaksi (id_pelanggan, kode, layanan, berat, total_biaya, status) VALUES (:id_pelanggan, :kode, :layanan, :berat, :total_biaya, :status) RETURNING id_transaksi');
    $transaksi->execute([':id_pelanggan' => $idPelanggan, ':kode' => $kode, ':layanan' => $layanan, ':berat' => $berat, ':total_biaya' => $totalBiaya, ':status' => 'Diproses']);
    $idTransaksi = $transaksi->fetchColumn();

    $relasi = $koneksi->prepare('INSERT INTO pengambilan_laundry (id_transaksi, id_pelanggan) VALUES (:id_transaksi, :id_pelanggan)');
    $relasi->execute([':id_transaksi' => $idTransaksi, ':id_pelanggan' => $idPelanggan]);
    $koneksi->commit();
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Penerimaan laundry berhasil dicatat.'];
    header('Location: kembali.php'); exit;
} catch (Throwable $e) {
    if ($koneksi->inTransaction()) { $koneksi->rollBack(); }
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Penerimaan gagal. Kode transaksi mungkin sudah digunakan.'];
    header('Location: tambah.php'); exit;
}
