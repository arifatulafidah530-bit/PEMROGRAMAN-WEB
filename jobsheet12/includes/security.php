<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_base_path(): string
{
    $appRoot = realpath(dirname(__DIR__));
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');

    if ($appRoot === false || $documentRoot === false) {
        return '';
    }

    $appRoot = rtrim(str_replace('\\', '/', $appRoot), '/');
    $documentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');

    if ($appRoot === $documentRoot) {
        return '';
    }

    if (str_starts_with($appRoot, $documentRoot . '/')) {
        return '/' . substr($appRoot, strlen($documentRoot) + 1);
    }

    return '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_verify(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if ($sessionToken === '' || $submittedToken === '' || !hash_equals($sessionToken, $submittedToken)) {
        http_response_code(403);
        exit('Permintaan ditolak: token keamanan tidak valid.');
    }
}
