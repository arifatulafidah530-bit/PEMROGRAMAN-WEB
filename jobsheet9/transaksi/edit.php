<?php

$title = 'Edit Transaksi | LaundryKu';
$active = 'transaksi';

include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    header('Location: list.php');
    exit;
}

$stmt = $koneksi->prepare("
    SELECT *
    FROM transaksi
    WHERE id_transaksi = :id
");

$stmt->execute([
    ':id' => $id
]);

$transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaksi) {
    header('Location: list.php');
    exit;
}

$stmtPelanggan = $koneksi->query("
    SELECT id_pelanggan, nama
    FROM pelanggan
    ORDER BY nama ASC
");

$pelanggan = $stmtPelanggan->fetchAll(PDO::FETCH_ASSOC);

?>

<main>

    <div class="page-header">

        <h2>Edit Transaksi</h2>

        <p>
            Ubah data transaksi laundry.
        </p>

    </div>

    <div class="content-card">

        <form
            action="proses_edit.php"
            method="POST">

            <input
                type="hidden"
                name="id_transaksi"
                value="<?= htmlspecialchars($transaksi['id_transaksi']) ?>">

            <div class="form-grid">

                <div class="form-group">

                    <label for="kode">
                        Kode Transaksi
                    </label>

                    <input
                        type="text"
                        id="kode"
                        name="kode"
                        value="<?= htmlspecialchars($transaksi['kode']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label for="id_pelanggan">
                        Nama Pelanggan
                    </label>

                    <select
                        id="id_pelanggan"
                        name="id_pelanggan"
                        required>

                        <option value="">
                            Pilih pelanggan
                        </option>

                        <?php foreach ($pelanggan as $data): ?>

                            <option
                                value="<?= $data['id_pelanggan'] ?>"
                                <?= $transaksi['id_pelanggan'] == $data['id_pelanggan'] ? 'selected' : '' ?>>

                                <?= htmlspecialchars($data['nama']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="jenis_layanan">
                        Jenis Layanan
                    </label>

                    <select
                        id="jenis_layanan"
                        name="jenis_layanan"
                        required>

                        <option value="Cuci Kering"
                            <?= $transaksi['layanan'] === 'Cuci Kering' ? 'selected' : '' ?>>
                            Cuci Kering
                        </option>

                        <option value="Cuci Setrika"
                            <?= $transaksi['layanan'] === 'Cuci Setrika' ? 'selected' : '' ?>>
                            Cuci Setrika
                        </option>

                        <option value="Setrika"
                            <?= $transaksi['layanan'] === 'Setrika' ? 'selected' : '' ?>>
                            Setrika
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label for="berat">
                        Berat Laundry (kg)
                    </label>

                    <input
                        type="number"
                        id="berat"
                        name="berat"
                        min="1"
                        step="0.01"
                        value="<?= htmlspecialchars($transaksi['berat']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label for="total_biaya">
                        Total Biaya
                    </label>

                    <input
                        type="number"
                        id="total_biaya"
                        name="total_biaya"
                        min="0"
                        value="<?= htmlspecialchars($transaksi['total_biaya']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required>

                        <option value="Diproses"
                            <?= $transaksi['status'] === 'Diproses' ? 'selected' : '' ?>>
                            Diproses
                        </option>

                        <option value="Selesai"
                            <?= $transaksi['status'] === 'Selesai' ? 'selected' : '' ?>>
                            Selesai
                        </option>

                        <option value="Diambil"
                            <?= $transaksi['status'] === 'Diambil' ? 'selected' : '' ?>>
                            Diambil
                        </option>

                    </select>

                </div>

            </div>

            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-submit">

                    <i class="bi bi-save-fill"></i>

                    Simpan Perubahan

                </button>

                <a
                    href="list.php"
                    class="btn-reset">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

            </div>

        </form>

    </div>

</main>

<?php

include __DIR__ . '/../includes/footer.php';

?>