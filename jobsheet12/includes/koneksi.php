<?php

$railwayEnvironment = getenv('RAILWAY_ENVIRONMENT') !== false;
$host = getenv('PGHOST') ?: ($railwayEnvironment ? '' : 'localhost');
$port = getenv('PGPORT') ?: '5432';
$dbname = getenv('PGDATABASE') ?: ($railwayEnvironment ? '' : 'laundryku');
$user = getenv('PGUSER') ?: ($railwayEnvironment ? '' : 'postgres');
$password = getenv('PGPASSWORD') ?: ($railwayEnvironment ? '' : '12345678');
$sslmode = getenv('PGSSLMODE') ?: ($railwayEnvironment ? 'require' : 'prefer');

try {
    if ($host === '' || $dbname === '' || $user === '' || $password === '') {
        throw new RuntimeException('Konfigurasi koneksi PostgreSQL Railway belum lengkap. Atur PGHOST, PGDATABASE, PGUSER, dan PGPASSWORD.');
    }

    $koneksi = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode",
        $user,
        $password
    );

    $koneksi->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $koneksi->exec('CREATE TABLE IF NOT EXISTS tarif_layanan (id_tarif SERIAL PRIMARY KEY, nama VARCHAR(50) NOT NULL UNIQUE, harga_per_kg INTEGER NOT NULL CHECK (harga_per_kg >= 0))');
    $koneksi->exec("INSERT INTO tarif_layanan (nama, harga_per_kg) VALUES ('Cuci Kering', 5000), ('Cuci Setrika', 7000), ('Setrika', 4000) ON CONFLICT (nama) DO NOTHING");
    $koneksi->exec("ALTER TABLE transaksi ADD COLUMN IF NOT EXISTS dibayar INTEGER NOT NULL DEFAULT 0");
    $koneksi->exec("ALTER TABLE transaksi ADD COLUMN IF NOT EXISTS status_pembayaran VARCHAR(20) NOT NULL DEFAULT 'Belum Lunas'");

} catch (PDOException $e) {

    die("Koneksi database gagal: " . $e->getMessage());

}