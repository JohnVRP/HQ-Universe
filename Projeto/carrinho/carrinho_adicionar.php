<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../Arquivos/conexao.php';
require_once __DIR__ . '/../Arquivos/produtos.php';

// Padrão atual: todas as páginas enviam `id` (o ID real da tabela produtos).
// `codigo_catalogo` fica apenas como compatibilidade caso reste algum formulário antigo.
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $codigo = filter_input(INPUT_POST, 'codigo_catalogo', FILTER_VALIDATE_INT);
    $id = $codigo ? (int) (hqProdutoPorCodigo($pdo, $codigo)['id'] ?? 0) : 0;
}

$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
if (!$quantidade || $quantidade < 1) {
    $quantidade = 1;
}

$ajax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

if (!$id) {
    $mensagem = 'Produto inválido.';
    if ($ajax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(422);
        echo json_encode(['ok' => false, 'mensagem' => $mensagem], JSON_UNESCAPED_UNICODE);
        exit;
    }
    flash('erro', $mensagem);
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('loja.php')));
    exit;
}

$stmt = $pdo->prepare("\n    SELECT\n        p.id,\n        p.nome,\n        COALESCE(e.quantidade, 0) AS estoque\n    FROM produtos p\n    LEFT JOIN estoque e ON e.produto_id = p.id\n    WHERE p.id = ?\n      AND p.ativo = 1\n    LIMIT 1\n");
$stmt->execute([(int) $id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto || (int) $produto['estoque'] < 1) {
    $mensagem = 'Produto indisponível no estoque.';
    if ($ajax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(422);
        echo json_encode(['ok' => false, 'mensagem' => $mensagem], JSON_UNESCAPED_UNICODE);
        exit;
    }
    flash('erro', $mensagem);
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('loja.php')));
    exit;
}

$id = (int) $produto['id'];
$estoque = (int) $produto['estoque'];
$atual = (int) ($_SESSION['carrinho'][$id] ?? 0);
$_SESSION['carrinho'][$id] = min($estoque, $atual + $quantidade);

$mensagem = $produto['nome'] . ' foi adicionado ao carrinho.';
$qtdCarrinho = array_sum(array_map('intval', $_SESSION['carrinho']));

if ($ajax) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok' => true,
        'mensagem' => $mensagem,
        'quantidade' => $qtdCarrinho
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

flash('sucesso', $mensagem);
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('loja.php')));
exit;
