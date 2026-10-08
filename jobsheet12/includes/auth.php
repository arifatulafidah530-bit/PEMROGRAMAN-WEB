<?php

require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $base = app_base_path();
    header('Location: ' . $base . '/login.php');
    exit;
}
