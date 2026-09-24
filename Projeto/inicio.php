<?php
require_once __DIR__ . '/Arquivos/card_produto.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
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
  

  
  <!-- HEADER -->

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
  <!-- PRODUTOS -->
  <section class="container_index">
    <h2 class="titulo_index">
      Destaques
    </h2>
    <div class="produtos_index">
      <!-- PRODUTO 1 -->
      <?php hqCardProduto($pdo, 93, ['adicionar' => false, 'classe_preco' => 'preco_index', 'categoria' => 'Marvel']); ?>
      <!-- PRODUTO 2 -->
      <div class="card_index">
        <img alt="Capa da HQ Batman: Ano Um" src="../imagens/batman.jpg" />
        <div class="card-content_index">
          <div class="categoria">
            DC Comics
          </div>
          <h3 class="nomeproduto_index">
            Batman: Ano Um
          </h3>
          <p class="preco_index_2">
            R$ 54,90
          </p>
          <a class="comprar_index ver-mais" href="pesquisa.php?q=Batman">Ver Mais</a>
        </div>
      </div>
      <!-- PRODUTO 3 -->
      <?php hqCardProduto($pdo, 37, ['adicionar' => false, 'classe_preco' => 'preco_index_2', 'categoria' => 'Shounen']); ?>
      <!-- PRODUTO 4 -->
      <?php hqCardProduto($pdo, 41, ['adicionar' => false, 'classe_preco' => 'preco_index_2', 'categoria' => 'Aventura']); ?>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
<?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>
</body>

</html>
