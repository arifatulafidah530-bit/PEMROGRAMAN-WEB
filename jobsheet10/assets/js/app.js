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
    const formHapus = document.querySelectorAll(".form-hapus");

    formHapus.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            if (!confirm("Apakah kamu yakin ingin menghapus data ini?")) {
                event.preventDefault();
            }
        });
    });
}

function initFlashNotification() {
    const flashMessage = document.querySelector(".flash-message");

    if (flashMessage) {
        window.setTimeout(function () {
            flashMessage.remove();
        }, 3500);
    }
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

function initPriceCalculator() {
    const service = document.querySelector('#jenis_layanan');
    const weight = document.querySelector('#berat');
    const total = document.querySelector('#total_biaya');

    if (!service || !weight || !total) {
        return;
    }

    const updateTotal = function () {
        const selected = service.options[service.selectedIndex];
        const price = Number(selected?.dataset.harga || 0);
        const amount = Number(weight.value || 0);
        total.value = price > 0 && amount > 0 ? Math.ceil(price * amount) : '';
    };

    service.addEventListener('change', updateTotal);
    weight.addEventListener('input', updateTotal);
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initFlashNotification();
    initTableFilter();
    initValidasiForm();
    initPriceCalculator();
});
