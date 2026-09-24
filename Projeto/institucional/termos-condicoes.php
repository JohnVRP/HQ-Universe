<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Termos e Condições | HQ Universe</title>
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
             <h1>Termos e Condições</h1>

        <p>
            Ao utilizar a HQ Universe, o usuário concorda com as condições descritas abaixo.
        </p>

        <h2>Cadastro</h2>

        <ul>
            <li>Fornecer informações verdadeiras e atualizadas.</li>
            <li>Manter os dados cadastrais corretos.</li>
            <li>Proteger suas credenciais de acesso.</li>
        </ul>

        <h2>Utilização da Loja</h2>

        <ul>
            <li>Utilizar o site apenas para fins legais.</li>
            <li>Respeitar as regras de utilização da plataforma.</li>
        </ul>

        <h2>Produtos e Pedidos</h2>

        <ul>
            <li>Os preços podem ser alterados sem aviso prévio.</li>
            <li>A disponibilidade depende do estoque.</li>
            <li>O pedido somente será considerado concluído após sua confirmação.</li>
        </ul>

        <h2>Cancelamentos</h2>

        <ul>
            <li>Pedidos poderão ser cancelados em caso de erro evidente de preço.</li>
            <li>Pedidos poderão ser cancelados por inconsistências de estoque.</li>
            <li>Pedidos poderão ser cancelados por problemas cadastrais.</li>
        </ul>

        <h2>Imagens dos Produtos</h2>

        <ul>
            <li>As imagens possuem caráter ilustrativo.</li>
            <li>Pequenas diferenças de edição, capa ou acabamento podem ocorrer.</li>
        </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>