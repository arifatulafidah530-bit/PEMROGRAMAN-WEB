# LaundryKu - Jobsheet 13

Jobsheet 13 adalah versi deployment dan dokumentasi dari aplikasi LaundryKu.
Aplikasi melanjutkan fitur Jobsheet 12: autentikasi, CRUD pelanggan/transaksi,
penerimaan laundry, pengambilan, dan riwayat.

## Menjalankan Lokal

PowerShell:

```powershell
$env:DB_HOST = 'localhost'
$env:DB_PORT = '5432'
$env:DB_NAME = 'laundryku'
$env:DB_USER = 'postgres'
$env:DB_PASSWORD = 'password-postgresql-kamu'
php -S localhost:8000 -t .\jobsheet13
```

Buka `http://localhost:8000/register.php` untuk membuat akun petugas.

## Deployment

Atur environment variable berikut pada server hosting:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

Jangan commit file berisi password asli. Gunakan `.env.example` sebagai template.

## Pemeriksaan

```powershell
Get-ChildItem -Path . -Filter *.php -Recurse | ForEach-Object { php -l $_.FullName }
```
