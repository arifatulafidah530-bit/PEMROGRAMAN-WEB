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

} catch (PDOException $e) {

    die("Koneksi database gagal: " . $e->getMessage());

}