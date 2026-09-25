# Wireframe LaundryKu - Jobsheet 8

## 1. Halaman Beranda

Halaman beranda menampilkan informasi singkat mengenai LaundryKu.

Elemen:
- Logo LaundryKu
- Navigasi
- Ringkasan jumlah pelanggan
- Ringkasan jumlah transaksi
- Transaksi yang sedang diproses
- Transaksi yang selesai
- Informasi layanan laundry

## 2. Halaman Daftar Pelanggan

Halaman ini digunakan untuk menampilkan data pelanggan.

Elemen:
- Judul halaman
- Kolom pencarian
- Tabel pelanggan
- Nama pelanggan
- Nomor HP
- Alamat
- Jenis layanan
- Tombol Edit
- Tombol Hapus

Data pelanggan diambil dari tabel `pelanggan` PostgreSQL menggunakan PDO.

## 3. Halaman Tambah Pelanggan

Halaman ini digunakan untuk menambahkan data pelanggan.

Input:
- Nama pelanggan
- Nomor HP
- Alamat
- Jenis layanan

Form divalidasi di PHP sebelum data disimpan dengan prepared statement PDO.

## 4. Halaman Daftar Transaksi

Halaman ini digunakan untuk menampilkan transaksi laundry.

Elemen:
- Kode transaksi
- Nama pelanggan
- Jenis layanan
- Berat laundry
- Total biaya
- Status
- Tombol Edit
- Tombol Hapus

Data transaksi diambil dari tabel `transaksi` PostgreSQL menggunakan PDO.

## 5. Halaman Tambah Transaksi

Halaman ini digunakan untuk memasukkan transaksi baru.

Input:
- Kode transaksi
- Nama pelanggan
- Jenis layanan
- Berat laundry
- Total biaya
- Status

Form divalidasi di PHP sebelum data disimpan dengan prepared statement PDO.

## 6. Teknologi yang Digunakan

Website menggunakan:
- PHP
- PostgreSQL
- PDO
- HTML
- CSS
- Bootstrap
- Bootstrap Icons
- JavaScript