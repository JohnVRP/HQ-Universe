<?php if (session_status() !== PHP_SESSION_ACTIVE)
    session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Política de Privacidade | HQ Universe</title>
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
            <h1>Política de Privacidade</h1>

        <p>
            A HQ Universe respeita a privacidade dos seus usuários.
        </p>

        <h2>Os dados são utilizados para:</h2>

        <ul>
            <li>Autenticação de acesso.</li>
            <li>Atendimento ao cliente.</li>
            <li>Gerenciamento de pedidos.</li>
            <li>Melhoria dos serviços oferecidos.</li>
        </ul>

        <h2>Segurança</h2>

        <ul>
            <li>As senhas devem ser armazenadas utilizando hash seguro.</li>
            <li>Os dados pessoais não devem ser compartilhados para fins comerciais sem autorização.</li>
        </ul>

        <h2>Direitos do Usuário</h2>

        <ul>
            <li>Solicitar atualização dos dados cadastrais.</li>
            <li>Solicitar o encerramento da conta.</li>
        </ul>

        <h2>Conservação de Informações</h2>

        <ul>
            <li>Alguns registros poderão ser mantidos para fins de segurança e cumprimento de obrigações aplicáveis.</li>
        </ul>
        </article>
    </main>
    <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>