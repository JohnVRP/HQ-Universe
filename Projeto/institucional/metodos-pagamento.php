<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Métodos de Pagamento | HQ Universe</title>
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
            
        <h1>Métodos de Pagamento</h1>

        <p>
            A HQ Universe oferece diferentes formas de pagamento para demonstração do funcionamento da loja.
        </p>

        <h2>Formas de pagamento disponíveis</h2>

        <ul>
            <li>Pix.</li>
            <li>Cartão de crédito.</li>
            <li>Boleto bancário.</li>
        </ul>

        <h2>Informações importantes</h2>

        <ul>
            <li>Esta versão utiliza pagamentos simulados.</li>
            <li>Nenhuma cobrança real é processada.</li>
            <li>Em uma operação real, o pagamento deve ser realizado por um provedor certificado.</li>
        </ul>

        <h2>Segurança</h2>

        <ul>
            <li>Os dados completos do cartão nunca devem ser armazenados pela HQ Universe.</li>
            <li>O processamento deve ser realizado por um intermediador de pagamento certificado.</li>
        </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>