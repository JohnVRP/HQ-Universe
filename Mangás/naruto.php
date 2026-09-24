<?php
require_once __DIR__ . '/../Projeto/Arquivos/card_produto.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Loja de Quadrinhos inspirada na Panini" name="description" />
    <meta content="Arthur" name="author" />
    <title>NARUTO | HQ Universe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Bebas+Neue&amp;family=Poppins:wght@300;400;600&amp;display=swap"
        rel="stylesheet" />

  <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../CSS/funcionalidades.css?v=60">
</head>
<style>
    .hero {
        background: #111;
    }
</style>

<body>
  <?php require_once __DIR__ . '/../../../../Projeto/Arquivos/cabecalho.php'; ?>
  

    
    <!-- HEADER -->
    <!-- Trailer -->
    <section class="hero_2">
        <div class="hero-content">
            <h2 class="titulo_index_video">Trailer (Anime)</h2>
            <iframe
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen="" frameborder="0" height="315" referrerpolicy="strict-origin-when-cross-origin"
                src="https://www.youtube.com/embed/22R0j8UKRzY?si=6DCt3ee-OPfdepss" title="YouTube video player"
                width="700"></iframe>
        </div>
    </section>
    <!-- PRODUTOS -->
    <section class="container_index">
        <h2 class="titulo_index">Volumes Mais Vendidos</h2>
        <div class="produtos_index">
            <?php hqCardProduto($pdo, 33, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 34, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 35, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 36, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'SHOUNEN']); ?>
        </div>
    </section>
    <!-- Segunda Section-->
    <section class="container_index">
        <h2 class="titulo_index">Volumes 1-4 (Gold)</h2>
        <div class="produtos_index">
            <?php hqCardProduto($pdo, 37, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 38, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 39, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'SHOUNEN']); ?>
            <?php hqCardProduto($pdo, 40, ['adicionar' => true, 'classe_preco' => 'preco_index', 'categoria' => 'SHOUNEN']); ?>
        </div>
    </section>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../Projeto/Arquivos/rodape.php'; ?>
</body>

</html>