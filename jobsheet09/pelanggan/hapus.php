<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id_pelanggan'] ?? '';

if ($id === '' || !is_numeric($id)) {
    header('Location: list.php');
    exit;
}

try {

    $stmt = $koneksi->prepare("
        DELETE FROM pelanggan
        WHERE id_pelanggan = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Data pelanggan berhasil dihapus.'
    ];

} catch (PDOException $e) {

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Data pelanggan gagal dihapus.'
    ];

}

header('Location: list.php');
exit;