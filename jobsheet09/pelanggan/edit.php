<?php

$title = 'Edit Pelanggan | LaundryKu';
$active = 'pelanggan';

include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    header('Location: list.php');
    exit;
}

$stmt = $koneksi->prepare("
    SELECT *
    FROM pelanggan
    WHERE id_pelanggan = :id
");

$stmt->execute([
    ':id' => $id
]);

$pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelanggan) {
    header('Location: list.php');
    exit;
}

?>

<main>

    <div class="page-header">

        <h2>Edit Pelanggan</h2>

        <p>
            Ubah data pelanggan LaundryKu.
        </p>

    </div>

    <div class="content-card">

        <form
            action="proses_edit.php"
            method="POST">

            <input
                type="hidden"
                name="id_pelanggan"
                value="<?= htmlspecialchars($pelanggan['id_pelanggan']) ?>">

            <div class="form-grid">

                <div class="form-group">

                    <label for="nama">
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="<?= htmlspecialchars($pelanggan['nama']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label for="no_hp">
                        No. HP
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="<?= htmlspecialchars($pelanggan['no_hp']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label for="alamat">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        required><?= htmlspecialchars($pelanggan['alamat']) ?></textarea>

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
                            <?= $pelanggan['jenis_layanan'] === 'Cuci Kering' ? 'selected' : '' ?>>
                            Cuci Kering
                        </option>

                        <option value="Cuci Setrika"
                            <?= $pelanggan['jenis_layanan'] === 'Cuci Setrika' ? 'selected' : '' ?>>
                            Cuci Setrika
                        </option>

                        <option value="Setrika"
                            <?= $pelanggan['jenis_layanan'] === 'Setrika' ? 'selected' : '' ?>>
                            Setrika
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