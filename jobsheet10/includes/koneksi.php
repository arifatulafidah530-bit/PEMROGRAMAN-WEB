<?php

$databaseUrl = getenv('DATABASE_URL') ?: '';

if ($databaseUrl !== '') {
    $database = parse_url($databaseUrl);
    $host = $database['host'] ?? '';
    $port = $database['port'] ?? '5432';
    $dbname = ltrim($database['path'] ?? '', '/');
    $user = rawurldecode($database['user'] ?? '');
    $password = rawurldecode($database['pass'] ?? '');
    $sslmode = 'require';
} else {
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'laundryku';
    $user = getenv('DB_USER') ?: 'postgres';
    $password = getenv('DB_PASSWORD') ?: '';
    $sslmode = getenv('DB_SSLMODE') ?: 'prefer';
}

try {

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