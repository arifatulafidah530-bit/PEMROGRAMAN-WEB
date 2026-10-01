<?php

$title = 'Transaksi | LaundryKu';
$active = 'transaksi';

include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$perPage = 5;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$q = trim($_GET['q'] ?? '');

$where = '';
$params = [];

if ($q !== '') {

    $where = "
        WHERE transaksi.kode ILIKE :q
        OR pelanggan.nama ILIKE :q
        OR transaksi.layanan ILIKE :q
        OR transaksi.status ILIKE :q
    ";

    $params[':q'] = '%' . $q . '%';
}

$stmtCount = $koneksi->prepare("
    SELECT COUNT(*)
    FROM transaksi
    JOIN pelanggan
        ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    $where
");

foreach ($params as $key => $value) {
    $stmtCount->bindValue($key, $value);
}

$stmtCount->execute();

$totalData = $stmtCount->fetchColumn();

$totalPages = max(1, (int) ceil($totalData / $perPage));

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;

$stmt = $koneksi->prepare("
    SELECT
        transaksi.*,
        pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan
        ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    $where
    ORDER BY transaksi.id_transaksi DESC
    LIMIT :limit
    OFFSET :offset
");

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

$transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>

    <div class="page-header">

        <h2>Daftar Transaksi</h2>

        <p>
            Data transaksi laundry LaundryKu.
        </p>

    </div>

    <div class="content-card">

        <?php if (isset($_SESSION['flash'])): ?>

            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">

                <?= htmlspecialchars($_SESSION['flash']['message']) ?>

            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>

        <form
            action="list.php"
            method="GET"
            class="search-box">

            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($q) ?>"
                placeholder="Cari transaksi...">

        </form>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Kode</th>

                        <th>Nama Pelanggan</th>

                        <th>Layanan</th>

                        <th>Berat</th>

                        <th>Total Biaya</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($transaksi)): ?>

                        <tr>

                            <td colspan="7">
                                Data transaksi tidak ditemukan.
                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($transaksi as $data): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($data['kode']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama_pelanggan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['layanan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['berat']) ?> kg
                                </td>

                                <td>
                                    Rp <?= number_format($data['total_biaya'], 0, ',', '.') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['status']) ?>
                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="edit.php?id=<?= $data['id_transaksi'] ?>"
                                            class="btn-edit">

                                            <i class="bi bi-pencil-fill"></i>

                                            Edit

                                        </a>

                                        <form
                                            action="hapus.php"
                                            method="POST"
                                            class="form-hapus">

                                            <input
                                                type="hidden"
                                                name="id_transaksi"
                                                value="<?= $data['id_transaksi'] ?>">

                                            <button
                                                type="submit"
                                                class="btn-hapus">

                                                <i class="bi bi-trash-fill"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <?php if ($totalPages > 1): ?>

            <div class="pagination">

                <?php if ($page > 1): ?>

                    <a
                        href="?q=<?= urlencode($q) ?>&page=<?= $page - 1 ?>">

                        &laquo;

                    </a>

                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                    <a
                        href="?q=<?= urlencode($q) ?>&page=<?= $i ?>"
                        class="<?= $i === $page ? 'active' : '' ?>">

                        <?= $i ?>

                    </a>

                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>

                    <a
                        href="?q=<?= urlencode($q) ?>&page=<?= $page + 1 ?>">

                        &raquo;

                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

</main>

<?php

include __DIR__ . '/../includes/footer.php';

?>