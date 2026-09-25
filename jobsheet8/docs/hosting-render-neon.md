# Hosting Jobsheet 8 LaundryKu di Render + Neon

Panduan ini menjalankan PHP LaundryKu di Render dan PostgreSQL di Neon.
Setelah deploy selesai, komputer lokal, Laragon, dan terminal `php -S` tidak perlu menyala.

## 1. Siapkan repository GitHub

1. Buat repository GitHub baru.
2. Upload isi folder `jobsheet8` ke repository tersebut.
3. Pastikan `Dockerfile` berada di folder paling atas repository.
4. Jangan upload file `.env` atau password asli.

Jika seluruh workspace di-upload, atur Root Directory Render ke `jobsheet8`.

## 2. Buat database Neon

1. Buat project PostgreSQL di Neon.
2. Salin connection details dari Neon.
3. Jalankan isi `sql/laundryku.sql` di SQL Editor Neon.
4. Catat nilai host, port, database, user, dan password.

## 3. Buat Web Service Render

1. Buka Render dan pilih **New > Web Service**.
2. Hubungkan repository GitHub.
3. Jika repository berisi seluruh workspace, isi **Root Directory** dengan `jobsheet8`.
4. Pilih runtime **Docker**.
5. Pilih paket Free bila masih tersedia pada akun/region kamu.
6. Mulai deploy.

`Dockerfile` memasang `pdo_pgsql` dan menjalankan PHP pada port `PORT` milik Render.

## 4. Tambahkan Environment Variables Render

Di menu **Environment**, tambahkan:

```text
DB_HOST=host dari Neon
DB_PORT=5432
DB_NAME=database dari Neon
DB_USER=user dari Neon
DB_PASSWORD=password dari Neon
```

Jangan menulis tanda kutip dan jangan memakai `localhost` untuk `DB_HOST` production.

## 5. Uji hasil deploy

1. Buka URL Render.
2. Pastikan halaman Beranda muncul, bukan file PHP yang ter-download.
3. Buka Tambah Pelanggan dan simpan data uji.
4. Buka Transaksi dan pastikan data tersimpan.
5. Buka Neon untuk memastikan data masuk ke PostgreSQL online.

## 6. Jika error

- `could not find driver`: pastikan Render memakai `Dockerfile` ini.
- `connection refused`: periksa `DB_HOST` dan `DB_PORT` Neon.
- `password authentication failed`: periksa `DB_USER` dan `DB_PASSWORD`.
- Halaman PHP ter-download: service masih static hosting, ubah runtime menjadi Docker.
- Halaman kosong/500: buka menu **Logs** di Render.

## 7. Perbedaan lokal dan online

Lokal:

```powershell
php -S localhost:8000 -t .\jobsheet8
```

Online:

```text
Render menjalankan PHP di server
Neon menyediakan PostgreSQL online
Komputer kamu boleh dimatikan
```
