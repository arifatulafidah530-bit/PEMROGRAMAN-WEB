<?php

$host = "localhost";
$port = "5432";
$dbname = "laundryku";
$user = "postgres";
$password = "12345678";

try {

    $koneksi = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
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