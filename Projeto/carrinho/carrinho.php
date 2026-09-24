<?php session_start();
require_once __DIR__ . '/../Arquivos/conexao.php';
require_once __DIR__ . '/../Arquivos/funcoes.php';
$cart = $_SESSION['carrinho'] ?? [];
$produtos = [];
$total = 0;
if ($cart) {
    $ids = array_keys($cart);
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $st = $pdo->prepare("SELECT p.*,COALESCE(e.quantidade,0) estoque FROM produtos p LEFT JOIN estoque e ON e.produto_id=p.id WHERE p.id IN ($marks)");
    $st->execute($ids);
    foreach ($st as $p) {
        $p['quantidade'] = min((int) $cart[$p['id']], (int) $p['estoque']);
        $p['subtotal'] = $p['quantidade'] * $p['preco'];
        $total += $p['subtotal'];
        $produtos[] = $p;
    }
} ?><!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Carrinho</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

<link rel="stylesheet" href="../../CSS/carrinho.css?v=60">

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head>

<body class="pagina-carrinho">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  <?php mostrarFlash(); ?>
    <main class="conteudo limite">
        <h1>🛒 Carrinho</h1><br><?php if (!$produtos): ?>
            <div class="vazio">Seu carrinho está vazio.<br><br><a class="botao" href="../loja.php">Ver produtos</a></div>
        <?php else: ?>
            <form method="post" action="carrinho_atualizar.php" class="painel"><?php foreach ($produtos as $p): ?>
                    <div class="carrinho-item"><img src="<?= url('../imagens/' . rawurlencode($p['imagem'])) ?>">
                        <div><b><?= e($p['nome']) ?></b><br><?= moeda((float) $p['preco']) ?></div><input type="number"
                            name="quantidade[<?= $p['id'] ?>]" min="0" max="<?= $p['estoque'] ?>"
                            value="<?= $p['quantidade'] ?>"><b class="subtotal"><?= moeda((float) $p['subtotal']) ?></b><a
                            class="remover" href="carrinho_remover.php?id=<?= $p['id'] ?>">✕</a>
                    </div><?php endforeach; ?>
                <h2>Total: <?= moeda((float) $total) ?></h2><button class="botao-secundario" type="submit">Atualizar carrinho</button> <a
                    class="botao" href="checkout.php">Finalizar compra</a> <button class="botao-remover-todos" type="submit" name="acao" value="limpar" onclick="return confirm('Deseja remover todos os produtos do carrinho?');">Remover todos os produtos</button>
            </form><?php endif; ?>
    </main>
<?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>
</body>

</html>