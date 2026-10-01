function initNavToggle() {
    const navToggle = document.querySelector("#nav-toggle");
    const nav = document.querySelector("header nav");

    if (!navToggle || !nav) {
        return;
    }

    navToggle.addEventListener("change", function () {
        nav.classList.toggle("show", navToggle.checked);
    });
}

function initHapusConfirm() {
    const tombolHapus = document.querySelectorAll(".btn-hapus");

    tombolHapus.forEach(function (tombol) {
        tombol.addEventListener("click", function () {
            const baris = tombol.closest("tr");

            if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
                if (baris) {
                    baris.remove();
                }
            }
        });
    });
}

function initTableFilter() {
    const searchBox = document.querySelector("#search-box");
    const rows = document.querySelectorAll("table tbody tr");

    if (!searchBox || rows.length === 0) {
        return;
    }

    searchBox.addEventListener("keyup", function () {
        const keyword = searchBox.value.toLowerCase();

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();

            if (text.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

function initValidasiForm() {
    const form = document.querySelector("#form-tambah");

    if (!form) {
        return;
    }

    form.addEventListener("submit", function (event) {
        const inputs = form.querySelectorAll("[required]");
        let valid = true;

        inputs.forEach(function (input) {
            if (input.value.trim() === "") {
                input.style.borderColor = "#dc2626";
                valid = false;
            } else {
                input.style.borderColor = "";
            }
        });

        if (!valid) {
            event.preventDefault();
            alert("Silakan lengkapi data terlebih dahulu.");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});