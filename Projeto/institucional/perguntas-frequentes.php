<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Perguntas Frequentes | HQ Universe</title>
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
             <h1>Perguntas Frequentes</h1>

        <h2>Como acompanho meu pedido?</h2>

        <p>
            Acesse a página <strong>Meus Pedidos</strong> após realizar o login.
        </p>

        <h2>Como altero meus dados?</h2>

        <p>
            Utilize a página <strong>Meu Perfil</strong>.
        </p>

        <h2>Posso cancelar um pedido?</h2>

        <p>
            Pedidos que ainda não foram enviados poderão ser analisados para cancelamento.
        </p>

        <h2>Como calcular o frete?</h2>

        <p>
            Informe o CEP durante o checkout.
        </p>

        <h2>Por que um produto pode ficar indisponível?</h2>

        <ul>
            <li>O estoque é conferido quando o produto é adicionado ao carrinho.</li>
            <li>Uma nova verificação é realizada antes da finalização da compra.</li>
        </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>