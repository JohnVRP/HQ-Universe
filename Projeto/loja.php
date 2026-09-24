<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/Arquivos/card_produto.php';
?>
<!DOCTYPE html>

<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="Loja de quadrinhos, mangás e HQs da HQ Universe" name="description" />
  <meta content="Arthur" name="author" />
  <title>HQ Universe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Bebas+Neue&amp;family=Poppins:wght@300;400;600&amp;display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=banner-20260917-2">
  <link rel="stylesheet" href="../CSS/funcionalidades.css?v=60">
</head>

<body>
  <?php require_once __DIR__ . '/Arquivos/cabecalho.php'; ?>

  <!-- CABEÇALHO ÚNICO -->
  <?php
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
  ?>
  <!-- HERO -->
  <section class="hero" aria-label="HQ Universe">
    <picture>
      <source srcset="../imagens/banner_hq_universe.webp" type="image/webp">
      <img class="hero-banner" src="../imagens/banner_hq_universe.png"
        width="1920" height="700" fetchpriority="high"
        alt="HQ Universe. Mergulhe no seu universo de leitura. A maior coleção de HQs e mangás do Brasil.">
    </picture>
    <div class="hero-cta">
      <a class="btn_loja" href="explorar_colecao.php">Explorar Coleção</a>
    </div>
  </section>
  <!-- CONTEÚDO ORIGINAL EM TRÊS TÓPICOS -->
  <section class="container_index">
    <h2 class="titulo_index">Destaques</h2>
    <div class="produtos_index">
      <?php hqCardProduto($pdo, 82, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'Marvel']); ?>
      <?php hqCardProduto($pdo, 100, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'DC Comics']); ?>
      <?php hqCardProduto($pdo, 37, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
      <?php hqCardProduto($pdo, 41, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
    </div>
  </section>
  <section class="container_index">
    <h2 class="titulo_index">Mais Procurados</h2>
    <div class="produtos_index">
      <?php hqCardProduto($pdo, 21, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
      <?php hqCardProduto($pdo, 13, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
      <?php hqCardProduto($pdo, 1, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
      <?php hqCardProduto($pdo, 53, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
    </div>
  </section>
  <section class="container_index">
    <h2 class="titulo_index">Clássicos que Todo Fã Precisa Conhecer</h2>
    <div class="produtos_index">
      <?php hqCardProduto($pdo, 29, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Clássico']); ?>
      <?php hqCardProduto($pdo, 61, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Seinen']); ?>
      <?php hqCardProduto($pdo, 35, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Mangá']); ?>
      <?php hqCardProduto($pdo, 45, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Clássico']); ?>
    </div>
  </section>
  <?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
