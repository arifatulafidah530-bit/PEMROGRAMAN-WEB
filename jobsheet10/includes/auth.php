<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $base = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
    if ($base === '/') {
        $base = '';
    }

    header('Location: ' . $base . '/login.php');
    exit;
}
