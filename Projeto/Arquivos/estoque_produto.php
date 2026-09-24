<?php

declare(strict_types=1);

require_once __DIR__ . '/produtos.php';

function obterEstoqueProduto(PDO $pdo, ?int $produtoId, ?int $codigoCatalogo = null): int
{
    $produto = $codigoCatalogo !== null
        ? hqProdutoPorCodigo($pdo, $codigoCatalogo)
        : ($produtoId !== null ? hqProdutoPorId($pdo, $produtoId) : null);
    return max(0, (int) ($produto['estoque'] ?? 0));
}

function classeEstoqueProduto(int $quantidade): string
{
    if ($quantidade <= 0) return 'sem-estoque';
    if ($quantidade <= 3) return 'estoque-baixo';
    return 'estoque-disponivel';
}

function textoEstoqueProduto(int $quantidade): string
{
    if ($quantidade <= 0) return 'Produto temporariamente indisponível';
    if ($quantidade === 1) return 'Última unidade disponível';
    if ($quantidade <= 3) return 'Apenas ' . $quantidade . ' unidades disponíveis';
    return $quantidade . ' unidades disponíveis';
}
