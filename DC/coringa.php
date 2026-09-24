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

    <title>CORINGA | HQ Universe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />

    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=60">
    <link rel="stylesheet" href="../CSS/funcionalidades.css?v=60">

</head>

<style>
.hero{
    background:#111;
}
</style>

<body>

<?php require_once __DIR__ . '/../../../../Projeto/Arquivos/cabecalho.php'; ?>

<!-- Trailer -->
<section class="hero_2">
        <div class="hero-content">
            <h2 class="titulo_index_video">Trailer (Filme)</h2>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/jfVTJm9NilA?si=ia0_nVXwfsKn6GKr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </section>
<!-- PRODUTOS -->

<section class="container_index">

    <h2 class="titulo_index">Volumes Marcantes</h2>

    <div class="produtos_index">

        <!-- Produto 1 -->

        <?php hqCardProduto($pdo, 102, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Vilão']); ?>

        <!-- Produto 2 -->

        <?php hqCardProduto($pdo, 103, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Vilão']); ?>

        <!-- Produto 3 -->

        <?php hqCardProduto($pdo, 104, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Vilão']); ?>

        <!-- Produto 4 -->

        <?php hqCardProduto($pdo, 105, ['adicionar' => true, 'classe_preco' => 'preco_index_2', 'categoria' => 'Vilão']); ?>

    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../Projeto/Arquivos/rodape.php'; ?>

</body>

</html>