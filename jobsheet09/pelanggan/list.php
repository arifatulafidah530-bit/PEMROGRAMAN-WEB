<?php

$title = 'Pelanggan | LaundryKu';
$active = 'pelanggan';

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
        WHERE nama ILIKE :q
        OR no_hp ILIKE :q
        OR alamat ILIKE :q
        OR jenis_layanan ILIKE :q
    ";

    $params[':q'] = '%' . $q . '%';
}

$stmtCount = $koneksi->prepare("
    SELECT COUNT(*)
    FROM pelanggan
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
    SELECT *
    FROM pelanggan
    $where
    ORDER BY id_pelanggan DESC
    LIMIT :limit
    OFFSET :offset
");

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

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

        <form
            action="list.php"
            method="GET"
            class="search-box">

            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($q) ?>"
                placeholder="Cari pelanggan...">

            <button type="submit">
                <i class="bi bi-search"></i>
                Cari
            </button>

        </form>

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
                                Data pelanggan tidak ditemukan.
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

                                        <a
                                            href="edit.php?id=<?= $data['id_pelanggan'] ?>"
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
                                                name="id_pelanggan"
                                                value="<?= $data['id_pelanggan'] ?>">

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