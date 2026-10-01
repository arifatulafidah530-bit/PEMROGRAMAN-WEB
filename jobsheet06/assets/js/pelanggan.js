async function tampilkanPelanggan() {
    const tabelPelanggan = document.querySelector("#tabel-pelanggan");

    if (!tabelPelanggan) {
        return;
    }

    tabelPelanggan.innerHTML = `
        <tr>
            <td colspan="5">Memuat data...</td>
        </tr>
    `;

    try {
        const response = await fetch("../data/pelanggan.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data pelanggan");
        }

        const dataPelanggan = await response.json();

        tabelPelanggan.innerHTML = "";

        dataPelanggan.forEach(function (pelanggan) {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${pelanggan.nama}</td>
                <td>${pelanggan.no_hp}</td>
                <td>${pelanggan.alamat}</td>
                <td>${pelanggan.jenis_layanan}</td>
                <td>
                    <button class="btn-edit">
                        <i class="bi bi-pencil-fill"></i>
                        Edit
                    </button>

                    <button class="btn-hapus">
                        <i class="bi bi-trash-fill"></i>
                        Hapus
                    </button>
                </td>
            `;

            tabelPelanggan.appendChild(row);
        });

        const tombolHapus = document.querySelectorAll(".btn-hapus");

        tombolHapus.forEach(function (tombol) {
            tombol.addEventListener("click", function () {
                const baris = tombol.closest("tr");

                if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
                    baris.remove();
                }
            });
        });

    } catch (error) {
        tabelPelanggan.innerHTML = `
            <tr>
                <td colspan="5">Gagal memuat data pelanggan.</td>
            </tr>
        `;

        console.error(error);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    tampilkanPelanggan();
});