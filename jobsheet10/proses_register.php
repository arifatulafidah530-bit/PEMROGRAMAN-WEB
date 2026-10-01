<?php
session_start();
require_once __DIR__ . '/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($nama === '' || $username === '' || $password === '') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Nama, username, dan password wajib diisi.'
    ];
    header('Location: register.php');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Password minimal terdiri dari 6 karakter.'
    ];
    header('Location: register.php');
    exit;
}

try {
    $check = $koneksi->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
    $check->execute([':username' => $username]);

    if ((int) $check->fetchColumn() > 0) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Username sudah digunakan.'
        ];
        header('Location: register.php');
        exit;
    }

    $stmt = $koneksi->prepare('INSERT INTO users (nama, username, password_hash) VALUES (:nama, :username, :password_hash)');
    $stmt->execute([
        ':nama' => $nama,
        ':username' => $username,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Registrasi berhasil. Silakan login.'
    ];
    header('Location: login.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Registrasi gagal diproses.'
    ];
    header('Location: register.php');
    exit;
}
