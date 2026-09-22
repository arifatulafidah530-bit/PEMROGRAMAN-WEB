<?php

$title = 'Tambah Pelanggan | LaundryKu';
$active = 'tambah-pelanggan';

include __DIR__ . '/../includes/header.php';

?>

<main>

    <div class="page-header">

        <h2>Tambah Pelanggan</h2>

        <p>
            Tambahkan data pelanggan baru.
        </p>

    </div>


    <div class="content-card">

        <?php if (isset($_SESSION['flash'])): ?>

            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">

                <?= htmlspecialchars($_SESSION['flash']['message']) ?>

            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>


        <form action="proses_tambah.php" method="POST">

            <div class="form-grid">

                <div class="form-group">

                    <label for="nama">
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
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
                        required>

                </div>


                <div class="form-group full">

                    <label for="alamat">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        required></textarea>

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