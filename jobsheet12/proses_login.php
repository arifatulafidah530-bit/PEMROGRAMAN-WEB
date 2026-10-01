<?php
session_start();
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/koneksi.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Username dan password wajib diisi.'
    ];
    header('Location: login.php');
    exit;
}

$stmt = $koneksi->prepare('SELECT id_user, username, nama, password_hash, role FROM users WHERE username = :username');
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Username atau password salah.'
    ];
    header('Location: login.php');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = $user['id_user'];
$_SESSION['username'] = $user['username'];
$_SESSION['nama_user'] = $user['nama'];
$_SESSION['role'] = $user['role'];

header('Location: index.php');
exit;
