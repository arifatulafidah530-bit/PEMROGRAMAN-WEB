<?php

$config = require __DIR__ . '/config.php';

$host = $config['host'];
$port = $config['port'];
$dbname = $config['name'];
$user = $config['user'];
$password = $config['password'];

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

} catch (PDOException $e) {

    die("Koneksi database gagal: " . $e->getMessage());

}