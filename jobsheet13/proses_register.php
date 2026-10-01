<?php
session_start();
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/koneksi.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirmation = $_POST['password_confirmation'] ?? '';

if ($nama === '' || $username === '' || $password === '' || $passwordConfirmation === '') {
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

if ($password !== $passwordConfirmation) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Konfirmasi password tidak sama.'
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

    $jumlahUser = (int) $koneksi->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $role = $jumlahUser === 0 ? 'admin' : 'petugas';

    $stmt = $koneksi->prepare('INSERT INTO users (nama, username, password_hash, role) VALUES (:nama, :username, :password_hash, :role)');
    $stmt->execute([
        ':nama' => $nama,
        ':username' => $username,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ':role' => $role
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
