<?php
declare(strict_types=1);
require_once __DIR__ . '/funcoes.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (
    !isset($_SESSION['valid'], $_SESSION['id']) ||
    $_SESSION['valid'] !== true
) {
    header('Location: ' . url('login.php'));
    exit;
}

if (($_SESSION['tipo'] ?? '') !== 'admin') {
    header('Location: ' . url('inicio.php'));
    exit;
}
