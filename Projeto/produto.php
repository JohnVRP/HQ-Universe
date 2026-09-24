<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/Arquivos/conexao.php';
require_once __DIR__ . '/Arquivos/produtos.php';
require_once __DIR__ . '/Arquivos/estoque_produto.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$codigo = filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT);
$produto = $id && $id > 0 ? hqProdutoPorId($pdo, $id) : ($codigo && $codigo > 0 ? hqProdutoPorCodigo($pdo, $codigo) : null);
if (!$produto) http_response_code(404);
$estoque = (int) ($produto['estoque'] ?? 0);
$parcelas = max(1, (int) ($produto['parcelas'] ?? 1));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($produto['nome'] ?? 'Produto não encontrado') ?> | HQ Universe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Bebas+Neue&amp;family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
  <link href="<?= e(url('../CSS/compra_jvrp.css?v=organizado-1')) ?>" rel="stylesheet">
  <link href="<?= e(url('../CSS/estilo_jvrp.css?v=organizado-1')) ?>" rel="stylesheet">
  <link href="<?= e(url('../CSS/funcionalidades.css?v=organizado-1')) ?>" rel="stylesheet">
</head>
<body>
  <?php require_once __DIR__ . '/Arquivos/cabecalho.php'; ?>
  <?php if (!$produto): ?>
    <main class="container_loja">
      <h1>Produto não encontrado</h1>
      <p>Este produto não está disponível no catálogo.</p>
      <a class="btn_loja" href="<?= e(url('loja.php')) ?>">Voltar para a loja</a>
    </main>
  <?php else: ?>
    <main>
      <section class="container_loja">
        <div class="produto-img_loja">
          <img src="<?= e(url('../imagens/' . ($produto['imagem'] ?: 'hq_universe.png'))) ?>" alt="<?= e($produto['nome']) ?>">
        </div>
        <div class="produto-info_loja">
          <div class="categoria_loja"><?= $estoque > 0 ? 'Disponível' : 'Indisponível' ?></div>
          <h1><?= e($produto['nome']) ?></h1>
          <p class="descricao_loja"><?= nl2br(e($produto['descricao'] ?? '')) ?></p>
          <div class="preco_loja"><?= moeda((float) $produto['preco']) ?></div>
          <div class="parcelamento_loja">
            <?php if ($parcelas > 1): ?>
              ou em até <?= $parcelas ?>x de <?= moeda((float) $produto['preco'] / $parcelas) ?> sem juros
            <?php else: ?>
              Pagamento em parcela única
            <?php endif; ?>
          </div>
          <div class="hq-estoque-produto <?= classeEstoqueProduto($estoque) ?>"><?= e(textoEstoqueProduto($estoque)) ?></div>
          <div class="comprar-area_loja">
            <form action="<?= e(url('carrinho_adicionar.php')) ?>" class="hq-form-carrinho" method="post">
              <input name="id" type="hidden" value="<?= (int) ($produto['id'] ?? 0) ?>">
              <input aria-label="Quantidade" name="quantidade" type="number" min="1" max="<?= max(1, $estoque) ?>" value="1" <?= $estoque < 1 ? 'disabled' : '' ?>>
              <button type="submit" <?= $estoque < 1 ? 'disabled' : '' ?>>Adicionar ao Carrinho</button>
            </form>
          </div>
          <div class="frete_loja">
            <h3>Calcular entrega</h3>
            <div class="frete-area_loja">
              <input id="cep-produto" aria-label="CEP para entrega" maxlength="9" placeholder="Digite seu CEP" type="text">
              <button onclick="calcularFreteHQ('cep-produto', 'frete-produto')" type="button">Calcular</button>
            </div>
            <div class="hq-frete-resultado" id="frete-produto"></div>
          </div>
        </div>
      </section>
      <section class="detalhes_loja">
        <h2>Detalhes do Produto</h2>
        <ul class="dados-produto-lista">
          <?php foreach (['autor' => 'Autor ou autores', 'ano_publicacao' => 'Ano de publicação', 'paginas' => 'Quantidade de Páginas', 'isbn' => 'ISBN'] as $campo => $rotulo): ?>
            <?php if (isset($produto[$campo]) && trim((string) $produto[$campo]) !== ''): ?>
              <li><strong><?= e($rotulo) ?>:</strong> <?= e((string) $produto[$campo]) ?></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </section>
    </main>
  <?php endif; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= e(url('../JS/frete.js')) ?>"></script>
  <?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>
</body>
</html>
