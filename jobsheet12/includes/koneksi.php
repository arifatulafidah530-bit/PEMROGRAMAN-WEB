<?php

$railwayEnvironment = getenv('RAILWAY_ENVIRONMENT') !== false;
$databaseUrl = getenv('DATABASE_URL') ?: '';
$urlParts = $databaseUrl !== '' ? parse_url($databaseUrl) : false;
$urlQuery = [];

if (is_array($urlParts) && isset($urlParts['query'])) {
    parse_str($urlParts['query'], $urlQuery);
}

$host = getenv('PGHOST') ?: getenv('DB_HOST') ?: ($urlParts['host'] ?? ($railwayEnvironment ? '' : 'localhost'));
$port = getenv('PGPORT') ?: getenv('DB_PORT') ?: ($urlParts['port'] ?? '5432');
$dbname = getenv('PGDATABASE') ?: getenv('DB_NAME') ?: (isset($urlParts['path']) ? ltrim($urlParts['path'], '/') : ($railwayEnvironment ? '' : 'laundryku'));
$user = getenv('PGUSER') ?: getenv('DB_USER') ?: (isset($urlParts['user']) ? rawurldecode($urlParts['user']) : ($railwayEnvironment ? '' : 'postgres'));
$password = getenv('PGPASSWORD') ?: getenv('DB_PASSWORD') ?: (isset($urlParts['pass']) ? rawurldecode($urlParts['pass']) : ($railwayEnvironment ? '' : '12345678'));
$sslmode = getenv('PGSSLMODE') ?: ($urlQuery['sslmode'] ?? ($railwayEnvironment ? 'require' : 'prefer'));

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