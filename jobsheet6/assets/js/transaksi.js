async function tampilkanTransaksi() {

    const tabelTransaksi = document.querySelector("#tabel-transaksi");

    if (!tabelTransaksi) {
        return;
    }

    tabelTransaksi.innerHTML = `
        <tr>
            <td colspan="6">Memuat data transaksi...</td>
        </tr>
    `;

    try {

        const response = await fetch("../data/transaksi.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data transaksi");
        }

        const dataTransaksi = await response.json();

        tabelTransaksi.innerHTML = "";

        dataTransaksi.forEach(function (transaksi) {

            const row = document.createElement("tr");

            let statusClass = "status-proses";
            let statusIcon = "bi-hourglass-split";

            if (transaksi.status.toLowerCase() === "selesai") {
                statusClass = "status-selesai";
                statusIcon = "bi-check-circle-fill";
            }

            if (transaksi.status.toLowerCase() === "diambil") {
                statusClass = "status-diambil";
                statusIcon = "bi-bag-check-fill";
            }

            row.innerHTML = `
                <td>${transaksi.pelanggan}</td>

                <td>${transaksi.layanan}</td>

                <td>${transaksi.berat} Kg</td>

                <td>Rp${Number(transaksi.total).toLocaleString("id-ID")}</td>

                <td>
                    <span class="status ${statusClass}">
                        <i class="bi ${statusIcon}"></i>
                        ${transaksi.status}
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
            `;

            tabelTransaksi.appendChild(row);

        });

    } catch (error) {

        tabelTransaksi.innerHTML = `
            <tr>
                <td colspan="6">
                    Gagal memuat data transaksi.
                </td>
            </tr>
        `;

        console.error(error);
    }
}


document.addEventListener("DOMContentLoaded", function () {
    tampilkanTransaksi();
});