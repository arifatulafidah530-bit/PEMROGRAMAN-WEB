<?php

$title = 'LaundryKu | Beranda';
$active = 'beranda';

include __DIR__ . '/includes/header.php';

?>

<main>

    <section class="hero">

        <div class="hero-content">

            <span class="hero-label">LAUNDRYKU</span>

            <h2>Kelola Laundry Jadi Lebih Mudah</h2>

            <p>
                Kelola data pelanggan dan transaksi laundry
                dengan lebih rapi dan praktis.
            </p>

            <a href="transaksi/tambah.php" class="hero-button">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Transaksi
            </a>

        </div>

        <div class="hero-icon">
            <i class="bi bi-basket2-fill"></i>
        </div>

    </section>


    <section class="section">

        <div class="section-heading">

            <div>

                <h2>Ringkasan Laundry</h2>

                <p>
                    Informasi data laundry saat ini.
                </p>

            </div>

        </div>


        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>

                    <span>Total Pelanggan</span>

                    <strong>
                        <?= count($_SESSION['pelanggan'] ?? []) ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div>

                    <span>Total Transaksi</span>

                    <strong>
                        <?= count($_SESSION['transaksi'] ?? []) ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div>

                    <span>Sedang Diproses</span>

                    <strong>
                        <?php

                        $jumlahProses = 0;

                        foreach ($_SESSION['transaksi'] ?? [] as $transaksi) {

                            if (($transaksi['status'] ?? '') === 'Diproses') {
                                $jumlahProses++;
                            }

                        }

                        echo $jumlahProses;

                        ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div>

                    <span>Transaksi Selesai</span>

                    <strong>
                        <?php

                        $jumlahSelesai = 0;

                        foreach ($_SESSION['transaksi'] ?? [] as $transaksi) {

                            if (($transaksi['status'] ?? '') === 'Selesai') {
                                $jumlahSelesai++;
                            }

                        }

                        echo $jumlahSelesai;

                        ?>
                    </strong>

                </div>

            </div>

        </div>

    </section>


    <section class="section">

        <div class="section-heading">

            <div>

                <h2>Layanan Laundry</h2>

                <p>
                    Pilihan layanan yang tersedia.
                </p>

            </div>

        </div>


        <div class="service-grid">

            <div class="service-card">

                <div class="service-icon">
                    <i class="bi bi-droplet-fill"></i>
                </div>

                <h3>Cuci Kering</h3>

                <p>
                    Layanan mencuci dan mengeringkan pakaian
                    dengan bersih dan rapi.
                </p>

            </div>


            <div class="service-card">

                <div class="service-icon">
                    <i class="bi bi-stars"></i>
                </div>

                <h3>Cuci Setrika</h3>

                <p>
                    Pakaian dicuci, dikeringkan, kemudian
                    disetrika hingga siap digunakan.
                </p>

            </div>


            <div class="service-card">

                <div class="service-icon">
                    <i class="bi bi-box-seam-fill"></i>
                </div>

                <h3>Setrika</h3>

                <p>
                    Layanan khusus untuk membuat pakaian
                    menjadi lebih rapi.
                </p>

            </div>

        </div>

    </section>

</main>

<?php

include __DIR__ . '/includes/footer.php';

?>