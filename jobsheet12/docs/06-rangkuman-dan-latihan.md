# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Jobsheet 12

| Area | Konsep yang Dipelajari | Implementasi LaundryKu |
|---|---|---|
| Relasi data laundry | Menghubungkan transaksi dengan pencatatan penerimaan/pengambilan | Tabel `pengambilan_laundry` mempunyai foreign key ke transaksi dan pelanggan, serta hanya satu catatan pengambilan untuk tiap transaksi di [03_pengambilan_laundry.sql](../sql/03_pengambilan_laundry.sql) |
| Penerimaan laundry | Membuat transaksi dan catatan pengambilan sebagai satu rangkaian | [proses_tambah.php](../pengambilan/proses_tambah.php) memakai `beginTransaction()`, `commit()`, dan `rollBack()` |
| Penguncian baris | Mencegah dua proses serentak memproses baris yang sama | Penerimaan mengunci baris pelanggan dengan `SELECT ... FOR UPDATE`; pengembalian/pengambilan mengunci catatan aktif di [proses_kembali.php](../pengambilan/proses_kembali.php) |
| Pengambilan laundry | Memperbarui status pengambilan dan status transaksi bersama-sama | [proses_kembali.php](../pengambilan/proses_kembali.php) mengubah catatan menjadi `selesai` dan transaksi menjadi `Diambil` dalam satu transaction |
| Riwayat dan `JOIN` | Menggabungkan informasi pengambilan, transaksi, dan pelanggan | [riwayat.php](../pengambilan/riwayat.php) menggabungkan ketiga tabel untuk menampilkan laundry yang sudah diambil |

## 6.2 Konsep Inti yang Perlu Diingat

1. `pengambilan_laundry` bukan tabel stok buku atau tabel many-to-many. Tabel ini mencatat status dan tanggal proses untuk transaksi laundry; satu transaksi hanya dapat mempunyai satu catatan pengambilan.
2. Transaction membuat beberapa perubahan database berhasil atau dibatalkan bersama-sama. Jika pembuatan transaksi atau catatan pengambilan gagal, proses penerimaan melakukan rollback.
3. `SELECT ... FOR UPDATE` mengunci baris yang sedang diproses sampai transaction selesai. Pada penerimaan, baris pelanggan dikunci; pada proses pengambilan, catatan pengambilan aktif dikunci. Mekanisme ini bukan pengendali stok.
4. Proses pengambilan memperbarui dua status yang saling berkaitan dalam satu transaction. Dengan begitu status catatan pengambilan dan status transaksi tidak seharusnya terpisah akibat kegagalan di tengah proses.
5. `JOIN ... ON` menggabungkan data dari `pengambilan_laundry`, `transaksi`, dan `pelanggan` berdasarkan ID yang berelasi.

## 6.3 Cara Mencoba Sendiri

Pastikan database `laundryku` dan tabel dasar `pelanggan` serta `transaksi` sudah tersedia. Dari root repository, jalankan skema tambahan dan mulai server bersama dari root repository:

```bash
psql -d laundryku -f jobsheet12/sql/03_pengambilan_laundry.sql
php -S localhost:8000 -t .
```

Buka Jobsheet 12 di `http://localhost:8000/jobsheet12/`. Akun pengguna Jobsheet 11 dan Jobsheet 12 disimpan di database yang sama, sehingga akun yang sudah terdaftar pada Jobsheet 11 dapat digunakan untuk login di sini.

1. Registrasikan petugas jika belum ada, lalu login.
2. Pastikan ada pelanggan terdaftar. Dari menu **Penerimaan**, catat laundry baru dengan pelanggan, kode, layanan, berat, dan biaya.
3. Periksa daftar laundry aktif. Penerimaan tersebut seharusnya membuat data transaksi dan catatan `pengambilan_laundry`.
4. Tandai laundry tersebut sudah diambil melalui menu **Pengambilan**. Periksa bahwa laundry hilang dari daftar aktif dan muncul di menu **Riwayat** dengan status selesai.
5. Logout dan coba membuka halaman yang dilindungi secara langsung. Pengguna seharusnya diarahkan ke login.

Untuk mencoba ringkasan **Total Sudah Dibayar**, tambahkan data melalui menu **Transaksi → Tambah Transaksi** dan isi kolom **Dibayar** dengan nominal lebih dari 0 (maksimal sebesar total biaya). Penerimaan laundry tidak mencatat pembayaran, sehingga nilainya tetap 0 sampai transaksi ditambahkan atau diperbarui melalui alur transaksi.

## 6.4 Ide Latihan Tambahan (Opsional)

1. Tambahkan validasi bisnis yang memang dibutuhkan LaundryKu, misalnya batas berat atau kewajiban melunasi pembayaran sebelum laundry ditandai sudah diambil.
2. Tambahkan kolom tanggal target selesai jika proses laundry memerlukannya. Tentukan aturan pengisian dan tampilannya sebelum mengubah skema.
3. Uji dua permintaan yang menandai catatan pengambilan aktif yang sama secara hampir bersamaan. Pastikan hanya satu proses yang berhasil mengubah status aktif menjadi selesai; jangan menguji skenario stok buku karena aplikasi ini tidak mengelola stok.
4. Tambahkan nomor HP pelanggan pada tabel riwayat dengan menambahkannya ke daftar kolom `SELECT` dan hasil `JOIN` di [riwayat.php](../pengambilan/riwayat.php).
5. Tinjau apakah penggunaan `SELECT ... FOR UPDATE` pada baris pelanggan sesuai dengan aturan bisnis penerimaan yang ingin diterapkan. Penguncian tersebut menyerialkan penerimaan untuk pelanggan yang sama, tetapi bukan pembatas jumlah laundry.
