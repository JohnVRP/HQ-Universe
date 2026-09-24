<?php
session_start();
require_once __DIR__ . '/../Arquivos/funcoes.php';

if (($_POST['acao'] ?? '') === 'limpar') {
    unset($_SESSION['carrinho']);
    header('Location: '.url('carrinho.php'));
    exit;
}

foreach ($_POST['quantidade'] ?? [] as $id => $q) {
    $id = (int) $id;
    $q = (int) $q;
    if ($q <= 0) {
        unset($_SESSION['carrinho'][$id]);
    } else {
        $_SESSION['carrinho'][$id] = $q;
    }
}

header('Location: '.url('carrinho.php'));
exit;
