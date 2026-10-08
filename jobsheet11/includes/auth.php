<?php

require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $base = '/' . basename(str_replace('\\', '/', dirname(__DIR__)));
    header('Location: ' . $base . '/login.php');
    exit;
}
