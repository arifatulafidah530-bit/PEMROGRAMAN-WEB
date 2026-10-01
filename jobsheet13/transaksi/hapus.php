<?php

require_once __DIR__ . '/../includes/auth.php';
csrf_verify();
require_admin();

require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id_transaksi'] ?? '';

if ($id === '' || !is_numeric($id)) {
    header('Location: list.php');
    exit;
}

try {

    $stmt = $koneksi->prepare("
        DELETE FROM transaksi
        WHERE id_transaksi = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Data transaksi berhasil dihapus.'
    ];

} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Data transaksi gagal dihapus.'
    ];

}

header('Location: list.php');
exit;