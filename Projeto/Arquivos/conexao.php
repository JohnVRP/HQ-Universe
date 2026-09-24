<?php
declare(strict_types=1);
require_once __DIR__ . '/funcoes.php';
$host=getenv('HQ_DB_HOST') !== false ? getenv('HQ_DB_HOST') : 'localhost'; $banco=getenv('HQ_DB_NAME') !== false ? getenv('HQ_DB_NAME') : 'db_quadrinhos_loja'; $usuario=getenv('HQ_DB_USER') !== false ? getenv('HQ_DB_USER') : 'root'; $senha=getenv('HQ_DB_PASSWORD') !== false ? getenv('HQ_DB_PASSWORD') : '';
try {
    $pdo=new PDO(getenv('HQ_DB_DSN') ?: "mysql:host={$host};dbname={$banco};charset=utf8mb4",$usuario,$senha,[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false,
    ]);
} catch(PDOException $e){ exit('Erro ao conectar ao banco: '.htmlspecialchars($e->getMessage())); }
