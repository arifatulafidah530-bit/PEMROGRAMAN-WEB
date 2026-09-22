<?php

$title = 'Transaksi | LaundryKu';
$active = 'transaksi';

include __DIR__ . '/../includes/header.php';

$transaksi = $_SESSION['transaksi'] ?? [];

$jumlahProses = 0;
$jumlahSelesai = 0;

foreach ($transaksi as $data) {

    if (($data['status'] ?? '') === 'Diproses') {
        $jumlahProses++;
    }

    if (($data['status'] ?? '') === 'Selesai') {
        $jumlahSelesai++;
    }

}

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

            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">

                <?= htmlspecialchars($_SESSION['flash']['message']) ?>

            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>


        <div class="transaction-summary">

            <div class="transaction-info">

                <span>Total Transaksi</span>

                <strong>
                    <?= count($transaksi) ?>
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


        <div class="search-box">

            <input
                type="text"
                id="search-box"
                placeholder="Cari transaksi...">

        </div>


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

                            if (($data['status'] ?? '') === 'Selesai') {

                                $statusClass = 'status-selesai';
                                $statusIcon = 'bi-check-circle-fill';

                            }

                            if (($data['status'] ?? '') === 'Diambil') {

                                $statusClass = 'status-diambil';
                                $statusIcon = 'bi-bag-check-fill';

                            }

                            ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($data['pelanggan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['layanan']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['berat']) ?> Kg
                                </td>

                                <td>
                                    Rp<?= number_format((int) $data['total'], 0, ',', '.') ?>
                                </td>

                                <td>

                                    <span class="status <?= $statusClass ?>">

                                        <i class="bi <?= $statusIcon ?>"></i>

                                        <?= htmlspecialchars($data['status']) ?>

                                    </span>

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