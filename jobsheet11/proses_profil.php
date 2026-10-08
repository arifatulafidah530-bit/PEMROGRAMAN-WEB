<?php
require_once __DIR__ . '/includes/auth.php';
csrf_verify();
require_once __DIR__ . '/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profil.php');
    exit;
}

$nama = $_POST['nama'] ?? '';
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if (!is_string($nama) || !is_string($currentPassword) || !is_string($newPassword) || !is_string($confirmPassword)) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data profil tidak valid.'];
    header('Location: profil.php');
    exit;
}

$nama = trim($nama);

if ($nama === '' || preg_match('/^.{1,100}$/us', $nama) !== 1 || $currentPassword === '') {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Nama dan password saat ini wajib diisi dengan benar.'];
    header('Location: profil.php');
    exit;
}

if (($newPassword !== '' || $confirmPassword !== '') && $newPassword !== $confirmPassword) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Konfirmasi password baru tidak cocok.'];
    header('Location: profil.php');
    exit;
}

if ($newPassword !== '' && strlen($newPassword) < 8) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Password baru minimal 8 karakter.'];
    header('Location: profil.php');
    exit;
}

$stmt = $koneksi->prepare('SELECT password_hash FROM users WHERE id_user = :id_user');
$stmt->execute([':id_user' => $_SESSION['user_id']]);
$passwordHash = $stmt->fetchColumn();

if ($passwordHash === false || !password_verify($currentPassword, $passwordHash)) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Password saat ini tidak sesuai.'];
    header('Location: profil.php');
    exit;
}

try {
    if ($newPassword === '') {
        $stmt = $koneksi->prepare('UPDATE users SET nama = :nama WHERE id_user = :id_user');
        $stmt->execute([':nama' => $nama, ':id_user' => $_SESSION['user_id']]);
    } else {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        if ($newPasswordHash === false) {
            throw new RuntimeException('Password baru gagal diproses.');
        }

        $stmt = $koneksi->prepare('UPDATE users SET nama = :nama, password_hash = :password_hash WHERE id_user = :id_user');
        $stmt->execute([
            ':nama' => $nama,
            ':password_hash' => $newPasswordHash,
            ':id_user' => $_SESSION['user_id']
        ]);
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Profil gagal diperbarui. Silakan coba lagi.'];
    header('Location: profil.php');
    exit;
}

$_SESSION['nama_user'] = $nama;
$_SESSION['flash'] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui.'];
header('Location: profil.php');
exit;
