<?php
require_once __DIR__ . '/../includes/auth.php';
csrf_verify();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: kembali.php'); exit; }
$id = $_POST['id_pengambilan'] ?? '';
if ($id === '' || !is_numeric($id)) { header('Location: kembali.php'); exit; }

try {
    $koneksi->beginTransaction();
    $stmt = $koneksi->prepare('SELECT id_transaksi FROM pengambilan_laundry WHERE id_pengambilan = :id AND status = :status FOR UPDATE');
    $stmt->execute([':id' => $id, ':status' => 'aktif']);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) { throw new RuntimeException('Data pengambilan tidak ditemukan.'); }

    $updateRelasi = $koneksi->prepare("UPDATE pengambilan_laundry SET status = 'selesai', tanggal_diambil = CURRENT_DATE WHERE id_pengambilan = :id");
    $updateRelasi->execute([':id' => $id]);
    $updateTransaksi = $koneksi->prepare("UPDATE transaksi SET status = 'Diambil' WHERE id_transaksi = :id");
    $updateTransaksi->execute([':id' => $data['id_transaksi']]);
    $koneksi->commit();
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Laundry berhasil ditandai sudah diambil.'];
} catch (Throwable $e) {
    if ($koneksi->inTransaction()) { $koneksi->rollBack(); }
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pengambilan laundry gagal diproses.'];
}
header('Location: kembali.php'); exit;
