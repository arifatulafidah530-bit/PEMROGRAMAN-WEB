<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $projectName = basename(str_replace('\\', '/', dirname(__DIR__)));
    $base = str_contains($scriptPath, '/' . $projectName . '/') ? '/' . $projectName : '';
    header('Location: ' . $base . '/login.php');
    exit;
}
