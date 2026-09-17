async function tampilkanBuku() {
    const tabelBuku = document.querySelector("#tabel-buku");

    if (!tabelBuku) {
        return;
    }

    tabelBuku.innerHTML = `
        <tr>
            <td colspan="5">Memuat data...</td>
        </tr>
    `;

    try {
        const response = await fetch("../data/buku.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data buku");
        }

        const dataBuku = await response.json();

        tabelBuku.innerHTML = "";

        dataBuku.forEach(function (buku) {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${buku.judul}</td>
                <td>${buku.pengarang}</td>
                <td>${buku.tahun}</td>
                <td>${buku.stok}</td>
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

            tabelBuku.appendChild(row);
        });

    } catch (error) {
        tabelBuku.innerHTML = `
            <tr>
                <td colspan="5">Gagal memuat data buku.</td>
            </tr>
        `;

        console.error(error);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    tampilkanBuku();
});