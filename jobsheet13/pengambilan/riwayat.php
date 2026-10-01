<?php
require_once __DIR__ . '/../includes/auth.php';
$title = 'Riwayat Laundry | LaundryKu';
$active = 'riwayat';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';
$stmt = $koneksi->query("SELECT p.tanggal_masuk, p.tanggal_diambil, t.kode, t.layanan, t.berat, t.total_biaya, pelanggan.nama AS nama_pelanggan FROM pengambilan_laundry p JOIN transaksi t ON t.id_transaksi = p.id_transaksi JOIN pelanggan ON pelanggan.id_pelanggan = p.id_pelanggan WHERE p.status = 'selesai' ORDER BY p.tanggal_diambil DESC, p.id_pengambilan DESC");
$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div class="page-header"><h2>Riwayat Laundry</h2><p>Daftar laundry yang sudah diambil pelanggan.</p></div>
    <div class="content-card"><div class="table-wrapper"><table><thead><tr><th>Kode</th><th>Pelanggan</th><th>Layanan</th><th>Tanggal Masuk</th><th>Tanggal Diambil</th><th>Status</th></tr></thead><tbody>
    <?php if (!$riwayat): ?><tr><td colspan="6">Belum ada riwayat laundry.</td></tr><?php else: foreach ($riwayat as $data): ?><tr><td><?= e($data['kode']) ?></td><td><?= e($data['nama_pelanggan']) ?></td><td><?= e($data['layanan']) ?></td><td><?= e($data['tanggal_masuk']) ?></td><td><?= e($data['tanggal_diambil']) ?></td><td>Selesai</td></tr><?php endforeach; endif; ?>
    </tbody></table></div></div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
