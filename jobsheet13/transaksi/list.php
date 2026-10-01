<?php

require_once __DIR__ . '/../includes/auth.php';

$title = 'Transaksi | LaundryKu';
$active = 'transaksi';

include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');
$dateFrom = trim($_GET['date_from'] ?? '');
$dateTo = trim($_GET['date_to'] ?? '');
$where = '';
$params = [];

$conditions = [];

if ($q !== '') {
    $conditions[] = "(
        transaksi.kode ILIKE :q
        OR pelanggan.nama ILIKE :q
        OR transaksi.layanan ILIKE :q
        OR transaksi.status ILIKE :q
    )";
    $params[':q'] = '%' . $q . '%';
}

if (in_array($status, ['Diproses', 'Selesai', 'Diambil'], true)) {
    $conditions[] = 'transaksi.status = :status';
    $params[':status'] = $status;
} else {
    $status = '';
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) {
    $dateFrom = '';
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
    $dateTo = '';
}

if ($dateFrom !== '') {
    $conditions[] = 'transaksi.created_at >= :date_from';
    $params[':date_from'] = $dateFrom . ' 00:00:00';
}

if ($dateTo !== '') {
    $conditions[] = "transaksi.created_at < (CAST(:date_to AS date) + INTERVAL '1 day')";
    $params[':date_to'] = $dateTo;
}

if ($conditions) {
    $where = 'WHERE ' . implode(' AND ', $conditions);
}

$stmtCount = $koneksi->prepare(" 
    SELECT COUNT(*)
    FROM transaksi
    JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    $where
");

foreach ($params as $key => $value) {
    $stmtCount->bindValue($key, $value);
}

$stmtCount->execute();
$totalData = (int) $stmtCount->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = $koneksi->prepare(" 
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    $where
    ORDER BY transaksi.id_transaksi DESC
    LIMIT :limit OFFSET :offset
");

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jumlahProses = (int) $koneksi->query("SELECT COUNT(*) FROM transaksi WHERE status = 'Diproses'")->fetchColumn();
$jumlahSelesai = (int) $koneksi->query("SELECT COUNT(*) FROM transaksi WHERE status = 'Selesai'")->fetchColumn();

?>

<main>

    <div class="page-header">

        <h2>Daftar Transaksi</h2>

        <p>
            Kelola data transaksi laundry dengan lebih mudah dan rapi.
        </p>

    </div>

    <div class="content-card">

        <?php if (isset($_SESSION['flash'])): ?>

            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">

                <?= e($_SESSION['flash']['message']) ?>

            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>

        <div class="transaction-summary">

            <div class="transaction-info">

                <span>Total Transaksi</span>

                <strong>
                    <?= $totalData ?>
                </strong>

            </div>

            <div class="transaction-info">

                <span>Sedang Diproses</span>

                <strong>
                    <?= $jumlahProses ?>
                </strong>

            </div>

            <div class="transaction-info">

                <span>Transaksi Selesai</span>

                <strong>
                    <?= $jumlahSelesai ?>
                </strong>

            </div>

        </div>

        <form action="list.php" method="GET" class="search-box">
            <input
                type="text"
                name="q"
                value="<?= e($q) ?>"
                placeholder="Cari transaksi...">
            <select name="status" aria-label="Filter status transaksi">
                <option value="">Semua status</option>
                <?php foreach (['Diproses', 'Selesai', 'Diambil'] as $statusOption): ?>
                    <option value="<?= e($statusOption) ?>" <?= $status === $statusOption ? 'selected' : '' ?>>
                        <?= e($statusOption) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label class="date-filter">
                <span>Dari</span>
                <input type="date" name="date_from" value="<?= e($dateFrom) ?>">
            </label>
            <label class="date-filter">
                <span>Sampai</span>
                <input type="date" name="date_to" value="<?= e($dateTo) ?>">
            </label>
            <button type="submit">
                <i class="bi bi-search"></i>
                Cari
            </button>
        </form>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Pelanggan</th>

                        <th>Jenis Layanan</th>

                        <th>Berat</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($transaksi)): ?>

                        <tr>

                            <td colspan="6">
                                Belum ada data transaksi.
                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($transaksi as $data): ?>

                            <?php

                            $statusClass = 'status-proses';
                            $statusIcon = 'bi-hourglass-split';

                            if ($data['status'] === 'Selesai') {

                                $statusClass = 'status-selesai';
                                $statusIcon = 'bi-check-circle-fill';

                            }

                            if ($data['status'] === 'Diambil') {

                                $statusClass = 'status-diambil';
                                $statusIcon = 'bi-bag-check-fill';

                            }

                            ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($data['nama_pelanggan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['layanan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['berat']) ?> Kg
                                </td>

                                <td>
                                    Rp<?= number_format((int) $data['total_biaya'], 0, ',', '.') ?>
                                </td>

                                <td>

                                    <span class="status <?= $statusClass ?>">

                                        <i class="bi <?= $statusIcon ?>"></i>

                                        <?= htmlspecialchars($data['status']) ?>

                                    </span>

                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                                            <a
                                                href="edit.php?id=<?= e($data['id_transaksi']) ?>"
                                                class="btn-edit">

                                            <i class="bi bi-pencil-fill"></i>

                                            Edit

                                            </a>

                                            <form
                                                action="hapus.php"
                                                method="POST"
                                                class="form-hapus">
                                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                                                <input
                                                    type="hidden"
                                                    name="id_transaksi"
                                                    value="<?= e($data['id_transaksi']) ?>">

                                                <button
                                                    type="submit"
                                                    class="btn-hapus">

                                                    <i class="bi bi-trash-fill"></i>

                                                    Hapus

                                                </button>

                                            </form>
                                        <?php endif; ?>

                                        <a
                                            href="struk.php?id=<?= e($data['id_transaksi']) ?>"
                                            class="btn-print"
                                            target="_blank">
                                            <i class="bi bi-printer-fill"></i>
                                            Struk
                                        </a>

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
                    <a href="?q=<?= urlencode($q) ?>&status=<?= urlencode($status) ?>&date_from=<?= urlencode($dateFrom) ?>&date_to=<?= urlencode($dateTo) ?>&page=<?= $page - 1 ?>">&laquo;</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a
                        href="?q=<?= urlencode($q) ?>&status=<?= urlencode($status) ?>&date_from=<?= urlencode($dateFrom) ?>&date_to=<?= urlencode($dateTo) ?>&page=<?= $i ?>"
                        class="<?= $i === $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?q=<?= urlencode($q) ?>&status=<?= urlencode($status) ?>&date_from=<?= urlencode($dateFrom) ?>&date_to=<?= urlencode($dateTo) ?>&page=<?= $page + 1 ?>">&raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

</main>

<?php

include __DIR__ . '/../includes/footer.php';

?>