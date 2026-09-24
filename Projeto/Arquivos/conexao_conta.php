<?php
declare(strict_types=1);
require_once __DIR__ . '/funcoes.php';

$servidor  = getenv('HQ_DB_HOST') !== false ? getenv('HQ_DB_HOST') : "localhost";
$nomeBanco = getenv('HQ_DB_NAME') !== false ? getenv('HQ_DB_NAME') : "db_quadrinhos_loja";
$usuario   = getenv('HQ_DB_USER') !== false ? getenv('HQ_DB_USER') : "Joao";
$senha     = getenv('HQ_DB_PASSWORD') !== false ? getenv('HQ_DB_PASSWORD') : "123";

try {

    $dsn = getenv('HQ_DB_DSN') ?: "mysql:host=$servidor;dbname=$nomeBanco;charset=utf8mb4";

    $configuracoes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $strcon = new PDO($dsn, $usuario, $senha, $configuracoes);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}