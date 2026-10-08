# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Jobsheet 11

| Area | Konsep yang Dipelajari | Implementasi LaundryKu |
|---|---|---|
| Output HTML dan XSS | Escape data sebelum ditampilkan sebagai HTML | Helper `e()` ada di [security.php](../includes/security.php); daftar pelanggan meng-escape nama, nomor HP, alamat, dan layanan di [list.php](../pelanggan/list.php) |
| CSRF | Token acak disimpan per sesi dan dibandingkan secara aman | `csrf_token()` memakai `random_bytes()` dan `csrf_verify()` memakai `hash_equals()` di [security.php](../includes/security.php) |
| Login dan session fixation | Regenerasi ID sesi setelah kredensial berhasil diverifikasi | [proses_login.php](../proses_login.php) memanggil `session_regenerate_id(true)` sebelum mengisi data pengguna ke sesi |
| Guard login | Halaman dan proses yang dilindungi harus memeriksa sesi pengguna | [auth.php](../includes/auth.php) mengarahkan pengguna yang belum login ke halaman login |
| SQL injection | Nilai dari pengguna dikirim sebagai parameter prepared statement | Proses login mengambil pengguna dengan parameter `:username` di [proses_login.php](../proses_login.php); proses transaksi juga menggunakan prepared statement di [proses_tambah.php](../transaksi/proses_tambah.php) |

## 6.2 Konsep Inti yang Perlu Diingat

1. Audit keamanan dapat mengonfirmasi bahwa pola yang sudah ada cukup aman; tidak semua temuan harus berujung pada penulisan ulang kode.
2. Escape data pada saat akan ditampilkan ke HTML. Gunakan `e()` untuk data yang ditampilkan pada form dan template yang menggunakannya. Beberapa keluaran daftar pelanggan saat ini memakai `htmlspecialchars()` secara langsung.
3. Metode `POST` tidak dengan sendirinya mencegah CSRF. Proses yang mengubah data memerlukan sesi yang sah dan token CSRF yang valid.
4. Pada proses yang dilindungi, urutannya adalah guard login lalu verifikasi CSRF. Karena itu, permintaan tanpa sesi login biasanya diarahkan ke login sebelum pemeriksaan token dilakukan.
5. `session_regenerate_id(true)` dipanggil setelah kredensial berhasil diverifikasi untuk mengganti ID sesi sebelum data login disimpan.
6. Prepared statement mencegah input seperti username `' OR '1'='1` diperlakukan sebagai bagian dari sintaks SQL.

## 6.3 Cara Mencoba Sendiri

Jalankan satu server dari root repository agar kedua jobsheet bisa diuji pada port yang sama:

```bash
php -S localhost:8000 -t .
```

Buka Jobsheet 11 di `http://localhost:8000/jobsheet11/` dan login melalui aplikasi tersebut.

1. **Uji XSS**: tambahkan pelanggan dengan nama `<script>alert(1)</script>`, lalu buka **Daftar Pelanggan**. Nilai nama seharusnya tampil sebagai teks dan tidak menjalankan pop-up.
2. **Uji guard login**: logout, lalu buka `http://localhost:8000/jobsheet11/transaksi/tambah.php`. Halaman seharusnya mengarahkan pengguna ke login Jobsheet 11.
3. **Uji urutan guard dan CSRF**: tanpa login, kirim POST ke `/jobsheet11/transaksi/proses_tambah.php`; permintaan seharusnya diarahkan ke login. Untuk menguji penolakan CSRF `403`, lakukan permintaan POST pada sesi Jobsheet 11 yang sudah login tetapi tanpa token CSRF yang valid. Contohnya, dari Console DevTools pada halaman Jobsheet 11 yang sama:

   ```javascript
   fetch('/jobsheet11/transaksi/proses_tambah.php', {
     method: 'POST',
     body: new URLSearchParams({})
   }).then(response => console.log(response.status))
   ```

   Permintaan ini tidak membawa token dan seharusnya menghasilkan status `403`. Jangan menyimpulkan hasil `403` dari `curl` tanpa cookie sesi: permintaan tanpa sesi lebih dahulu terkena guard login.
4. **Uji SQL injection**: pada halaman login Jobsheet 11, coba username `' OR '1'='1` dengan password sembarang. Login seharusnya gagal dan menampilkan pesan kredensial salah.

## 6.4 Ide Latihan Tambahan (Opsional)

1. Cari keluaran data lain dari database atau parameter `$_GET`/`$_POST` dan pastikan nilai yang menjadi teks HTML di-escape.
2. Tambahkan baris checklist audit untuk memeriksa apakah pesan error database atau PHP yang terlalu rinci pernah ditampilkan kepada pengguna.
3. Pelajari Content-Security-Policy (CSP) sebagai lapisan pertahanan tambahan terhadap XSS. CSP tidak menggantikan output escaping.
4. Ulangi pengujian CSRF dengan membandingkan permintaan tanpa login dan permintaan dari sesi login yang kehilangan token. Keduanya menguji guard yang berbeda.
