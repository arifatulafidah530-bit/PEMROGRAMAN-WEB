<?php
require_once __DIR__ . '/../includes/auth.php';
$title = 'Penerimaan Laundry | LaundryKu';
$active = 'pengambilan-baru';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';
$pelanggan = $koneksi->query('SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama')->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div class="page-header"><h2>Penerimaan Laundry</h2><p>Catat laundry yang baru diterima dari pelanggan.</p></div>
    <div class="content-card">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>"><?= e($_SESSION['flash']['message']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <form action="proses_tambah.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="form-grid">
                <div class="form-group"><label for="id_pelanggan">Pelanggan</label><input type="text" id="id_pelanggan" name="id_pelanggan" list="daftar-pelanggan" placeholder="Ketik nama pelanggan" autocomplete="off" required><datalist id="daftar-pelanggan"><?php foreach ($pelanggan as $data): ?><option value="<?= e($data['nama']) ?>"><?php endforeach; ?></datalist></div>
                <div class="form-group"><label for="kode">Kode Transaksi</label><input id="kode" name="kode" required></div>
                <div class="form-group"><label for="layanan">Jenis Layanan</label><select id="layanan" name="layanan" required><option value="">Pilih layanan</option><option>Cuci Kering</option><option>Cuci Setrika</option><option>Setrika</option></select></div>
                <div class="form-group"><label for="berat">Berat (kg)</label><input type="number" id="berat" name="berat" min="0.01" step="0.01" required></div>
                <div class="form-group"><label for="total_biaya">Total Biaya</label><input type="number" id="total_biaya" name="total_biaya" min="0" required></div>
            </div>
            <div class="form-actions"><button class="btn-submit" type="submit"><i class="bi bi-save-fill"></i> Simpan Penerimaan</button></div>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
