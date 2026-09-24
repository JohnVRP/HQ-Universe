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
    <title>THOR | HQ Universe</title>
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
            <h2 class="titulo_index_video">Trailer (Filme)</h2>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/8zJkPuHtZhU?si=2b6RgdFcQTO74g5T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </section>
    <!-- PRODUTOS -->
    <section class="container_index">
        <h2 class="titulo_index">Volumes Marcantes</h2>
        <div class="produtos_index">
            <?php hqCardProduto($pdo, 85, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Deus do trovão']); ?>
            <?php hqCardProduto($pdo, 86, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Deus do trovão']); ?>
            <?php hqCardProduto($pdo, 87, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Deus do trovão']); ?>
            <?php hqCardProduto($pdo, 88, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Deus do trovão']); ?>
        </div>
    </section>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../Projeto/Arquivos/rodape.php'; ?>
</body>

</html>