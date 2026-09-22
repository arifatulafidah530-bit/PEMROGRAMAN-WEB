<?php

$title = 'LaundryKu | Tambah Transaksi';
$active = 'transaksi';

include __DIR__ . '/../includes/header.php';

?>

<main>

    <div class="page-header">

        <h2>Tambah Transaksi</h2>

        <p>
            Tambahkan transaksi laundry baru.
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
            action="proses_tambah.php"
            method="POST">

            <div class="form-grid">

                <div class="form-group">

                    <label for="kode">
                        Kode Transaksi
                    </label>

                    <input
                        type="text"
                        id="kode"
                        name="kode"
                        required>

                </div>


                <div class="form-group">

                    <label for="nama_pelanggan">
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        id="nama_pelanggan"
                        name="nama_pelanggan"
                        required>

                </div>


                <div class="form-group">

                    <label for="jenis_layanan">
                        Jenis Layanan
                    </label>

                    <select
                        id="jenis_layanan"
                        name="jenis_layanan"
                        required>

                        <option value="">
                            Pilih layanan
                        </option>

                        <option value="Cuci Kering">
                            Cuci Kering
                        </option>

                        <option value="Cuci Setrika">
                            Cuci Setrika
                        </option>

                        <option value="Setrika">
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

                        <option value="">
                            Pilih status
                        </option>

                        <option value="Diproses">
                            Diproses
                        </option>

                        <option value="Selesai">
                            Selesai
                        </option>

                        <option value="Diambil">
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

                    Simpan

                </button>


                <button
                    type="reset"
                    class="btn-reset">

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </button>

            </div>

        </form>

    </div>

</main>

<?php

include __DIR__ . '/../includes/footer.php';

?>