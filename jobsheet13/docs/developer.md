# Dokumentasi Developer LaundryKu

## Arsitektur

- PHP menangani halaman dan proses form.
- PostgreSQL menyimpan pelanggan, transaksi, users, dan pengambilan laundry.
- PDO prepared statement digunakan untuk query dengan input pengguna.
- `auth.php` melindungi halaman internal.
- `security.php` menyediakan escaping `e()` dan token CSRF.
- `config.php` membaca konfigurasi dari environment variable.

## Relasi Data

```text
pelanggan 1 ---- banyak transaksi
pelanggan 1 ---- banyak pengambilan_laundry
transaksi 1 ---- 1 pengambilan_laundry
users menyimpan akun petugas
```

## Deployment

Kode tidak menyimpan password database. Nilai koneksi dibaca melalui
`getenv()` di `includes/config.php`, dengan fallback yang aman untuk host lokal.

## Checklist

- [ ] PostgreSQL aktif
- [ ] Skema `laundryku.sql` sudah dijalankan
- [ ] Skema `02_users.sql` sudah dijalankan
- [ ] Skema `03_pengambilan_laundry.sql` sudah dijalankan
- [ ] Environment variable database sudah diatur
- [ ] Tidak ada password asli di repository
- [ ] Seluruh file PHP lulus `php -l`
