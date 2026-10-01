# Matriks Fitur dan Role LaundryKu

| Fitur | Petugas | Admin |
|---|---:|---:|
| Melihat beranda | Ya | Ya |
| Mengelola pelanggan | Ya | Ya |
| Mengelola transaksi | Ya | Ya |
| Mencatat penerimaan | Ya | Ya |
| Memproses pengambilan | Ya | Ya |
| Melihat riwayat | Ya | Ya |
| Mengelola akun | Belum tersedia | Belum tersedia |

Role disimpan pada session dan database. Akun pertama yang didaftarkan otomatis
menjadi `admin`; akun berikutnya menjadi `petugas`. Edit dan hapus hanya tersedia
untuk admin, sedangkan petugas tetap dapat menjalankan operasional laundry.
