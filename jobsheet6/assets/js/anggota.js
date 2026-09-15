async function muatDaftarAnggota() {
    const tbody = document.querySelector("#tabel-anggota");
    if (!tbody) return;

    tbody.innerHTML = `
        <tr>
            <td colspan="5">Memuat data...</td>
        </tr>
    `;

    try {
        const response = await fetch("../data/anggota.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data anggota.");
        }

        const dataAnggota = await response.json();
        tbody.innerHTML = "";

        dataAnggota.forEach(function (anggota) {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${anggota.no_anggota}</td>
                <td>${anggota.nama}</td>
                <td>${anggota.alamat}</td>
                <td>${anggota.no_hp}</td>
                <td>
                    <button type="button">Edit</button>
                    <button type="button" class="btn-hapus">Hapus</button>
                </td>
            `;

            tbody.appendChild(row);
        });
    } catch (error) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5">Gagal memuat data anggota.</td>
            </tr>
        `;
    }
}
document.addEventListener("DOMContentLoaded", muatDaftarAnggota);