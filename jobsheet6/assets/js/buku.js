async function muatDaftarBuku() {
    const tbody = document.querySelector("#tabel-buku");

    if (!tbody) return;

    tbody.innerHTML = `
        <tr>
            <td colspan="5">Memuat data...</td>
        </tr>
    `;

    try {
        const response = await fetch("../data/buku.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data buku.");
        }

        const dataBuku = await response.json();

        tbody.innerHTML = "";

        dataBuku.forEach(function (buku) {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${buku.judul}</td>
                <td>${buku.pengarang}</td>
                <td>${buku.tahun}</td>
                <td>${buku.stok}</td>
                <td>
                    <button type="button">Edit</button>
                    <button type="button" class="btn-hapus">Hapus</button>
                </td>
            `;

            tbody.appendChild(row);
        });
    } catch (error) {
        console.error(error);

        tbody.innerHTML = `
            <tr>
                <td colspan="5">Gagal memuat data buku.</td>
            </tr>
        `;
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);