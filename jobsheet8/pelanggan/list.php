<?php

$title = 'Pelanggan | LaundryKu';
$active = 'pelanggan';

include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$stmt = $koneksi->query("SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
$pelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>

    <div class="page-header">

        <h2>Daftar Pelanggan</h2>

        <p>
            Data pelanggan LaundryKu.
        </p>

    </div>

    <div class="content-card">

        <?php if (isset($_SESSION['flash'])): ?>

            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
                <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>

        <div class="search-box">

            <input
                type="text"
                id="search-box"
                placeholder="Cari pelanggan...">

        </div>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Nama Pelanggan</th>

                        <th>No. HP</th>

                        <th>Alamat</th>

                        <th>Jenis Layanan</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($pelanggan)): ?>

                        <tr>

                            <td colspan="5">
                                Belum ada data pelanggan.
                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($pelanggan as $data): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($data['nama']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['no_hp']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['alamat']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['jenis_layanan']) ?>
                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <button class="btn-edit">
                                            <i class="bi bi-pencil-fill"></i>
                                            Edit
                                        </button>

                                        <button class="btn-hapus">
                                            <i class="bi bi-trash-fill"></i>
                                            Hapus
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

<?php

include __DIR__ . '/../includes/footer.php';

?>