<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Regulamentos | HQ Universe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../../CSS/institucional.css?v=60">

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head>

<body class="pagina-institucional">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  
    
    <main class="hq-institucional">
        <article>
            <h1>Regulamentos</h1>

        <h2>Promoções</h2>

        <ul>
            <li>Possuem período de validade.</li>
            <li>Informam os produtos participantes.</li>
            <li>Apresentam regras específicas em cada campanha.</li>
        </ul>

        <h2>Cupons</h2>

        <ul>
            <li>Não são cumulativos, salvo indicação expressa.</li>
        </ul>

        <h2>Uso Indevido</h2>

        <p>As seguintes práticas poderão resultar no bloqueio da conta:</p>

        <ul>
            <li>Tentativas de fraude.</li>
            <li>Manipulação de preços.</li>
            <li>Uso automatizado indevido.</li>
            <li>Práticas que prejudiquem o funcionamento da loja.</li>
        </ul>

        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>