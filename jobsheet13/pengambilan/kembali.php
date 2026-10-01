<?php
require_once __DIR__ . '/../includes/auth.php';
$title = 'Pengambilan Laundry | LaundryKu';
$active = 'pengambilan';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';
$stmt = $koneksi->query("SELECT p.id_pengambilan, p.tanggal_masuk, t.kode, t.layanan, t.berat, t.total_biaya, pelanggan.nama AS nama_pelanggan FROM pengambilan_laundry p JOIN transaksi t ON t.id_transaksi = p.id_transaksi JOIN pelanggan ON pelanggan.id_pelanggan = p.id_pelanggan WHERE p.status = 'aktif' ORDER BY p.id_pengambilan DESC");
$dataAktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div class="page-header"><h2>Pengambilan Laundry</h2><p>Daftar laundry yang masih aktif dan belum diambil pelanggan.</p></div>
    <div class="content-card">
        <?php if (isset($_SESSION['flash'])): ?><div class="flash-message <?= e($_SESSION['flash']['type']) ?>"><?= e($_SESSION['flash']['message']) ?></div><?php unset($_SESSION['flash']); endif; ?>
        <div class="table-wrapper"><table><thead><tr><th>Kode</th><th>Pelanggan</th><th>Layanan</th><th>Masuk</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        <?php if (!$dataAktif): ?><tr><td colspan="6">Belum ada laundry aktif.</td></tr><?php else: foreach ($dataAktif as $data): ?><tr><td><?= e($data['kode']) ?></td><td><?= e($data['nama_pelanggan']) ?></td><td><?= e($data['layanan']) ?></td><td><?= e($data['tanggal_masuk']) ?></td><td>Diproses</td><td><form action="proses_kembali.php" method="POST"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id_pengambilan" value="<?= e($data['id_pengambilan']) ?>"><button class="btn-submit" type="submit"><i class="bi bi-check-circle-fill"></i> Tandai Diambil</button></form></td></tr><?php endforeach; endif; ?>
        </tbody></table></div>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
