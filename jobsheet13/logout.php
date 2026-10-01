<?php
require_once __DIR__ . '/includes/security.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: index.php');
	exit;
}

$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
