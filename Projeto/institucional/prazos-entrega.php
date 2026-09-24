<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Prazos de Entrega | HQ Universe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

<link rel="stylesheet" href="../../CSS/institucional.css?v=60">

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head>

<body class="pagina-institucional">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  
    
    <main class="hq-institucional">
        <article>
            <h1>Prazos de Entrega</h1>

            <p>
                A origem das entregas é <b>São Paulo/SP.</b>
            </p>

            <h2>Como funciona o prazo de entrega</h2>

            <ul>
                <li>O prazo informado no checkout é uma estimativa calculada pela região do CEP.</li>
                <li>A contagem inicia após a confirmação do pedido.</li>
                <li>Entregas para São Paulo costumam ter prazo reduzido.</li>
                <li>Demais regiões possuem prazos proporcionais à distância.</li>
            </ul>

            <h2>Possíveis fatores de atraso</h2>

            <ul>
                <li>Condições climáticas.</li>
                <li>Greves ou paralisações.</li>
                <li>Problemas logísticos.</li>
                <li>Endereço informado incorretamente.</li>
            </ul>

            <h2>Importante</h2>

            <ul>
                <li>Confira CEP, número e complemento antes de finalizar a compra.</li>
            </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>