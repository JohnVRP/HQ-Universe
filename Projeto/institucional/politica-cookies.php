<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Política de Cookies | HQ Universe</title>
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
             <h1>Política de Cookies</h1>

        <p>
            A HQ Universe utiliza cookies para melhorar a experiência durante a navegação.
        </p>

        <h2>Cookies Utilizados</h2>

        <ul>
            <li>Cookies de sessão.</li>
            <li>Cookies para manter o login.</li>
            <li>Cookies para manter o carrinho durante a navegação.</li>
        </ul>

        <h2>Segurança</h2>

        <ul>
            <li>Senhas nunca devem ser armazenadas em cookies.</li>
        </ul>

        <h2>Cookies Opcionais</h2>

        <ul>
            <li>Cookies de análise.</li>
            <li>Cookies estatísticos.</li>
            <li>Cookies de publicidade, mediante consentimento do usuário.</li>
        </ul>

        <h2>Encerramento da Sessão</h2>

        <ul>
            <li>Ao sair da conta, a sessão de autenticação é encerrada.</li>
            <li>Algumas informações técnicas poderão permanecer até o fechamento completo do navegador.</li>
        </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>