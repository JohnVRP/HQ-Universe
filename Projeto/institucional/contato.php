<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>

<html lang="pt-BR">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Contato | HQ Universe</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Bebas+Neue&amp;family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet"/>
<style>
    .navbar-hq {
      background: #ffd100;
    }

    .navbar-hq .navbar-brand {
      font-family: "Bangers", sans-serif;
      font-size: 2rem;
      font-weight: bold;
      color: #000;
    }

    .navbar-hq .nav-link {
      color: #000;
      font-weight: bold;
      transition: .3s;
    }

    .navbar-hq .nav-link:hover {
      color: #e30613;
    }

    .navbar-hq .nav-link.active {
      color: #e30613 !important;
    }

    /* Banner */

    .banner {
      height: 320px;
      background: linear-gradient(rgba(0, 0, 0, .65), rgba(0, 0, 0, .65)),
        url("https://images.unsplash.com/photo-1515879218367-8466d910aaa4?q=80&w=1400&auto=format&fit=crop");
      background-size: cover;
      background-position: center;
    }

    .banner h1 {
      font-size: 60px;
      font-weight: bold;
    }

    /* Cards */

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
    }

    .titulo {
      color: var(--vermelho);
      font-weight: bold;
    }

    .btn-enviar {
      background: var(--preto);
      color: white;
      font-weight: bold;
    }

    .btn-enviar:hover {
      background: var(--vermelho);
      color: white;
    }

    footer {
      background: black;
    }
  </style>

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head>
<body>
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  

<!-- Navbar -->

<!-- Banner -->
<section class="banner d-flex align-items-center justify-content-center text-white text-center">
<div>
<h1>Contato</h1>
<p class="fs-5">Fale com nossa equipe e envie suas dúvidas.</p>
</div>
</section>
<!-- Conteúdo -->
<div class="container py-5">
<div class="row g-4">
<!-- Informações -->
<div class="col-lg-6">
<div class="card h-100">
<div class="card-body p-4">
<h2 class="titulo mb-4">Entre em Contato</h2>
<p>
              Tem alguma dúvida sobre produtos, pedidos ou coleções?
              Nossa equipe está pronta para ajudar.
            </p>
<hr/>
<p><strong>Email:</strong> contato@hquniverse.com</p>
<p><strong>Telefone:</strong> (11) 99999-9999</p>
<p><strong>Endereço:</strong> São Paulo - SP</p>
<p><strong>Horário:</strong> Segunda a sexta, das 09h às 18h.</p>
</div>
</div>
</div>
<!-- Formulário -->
<div class="col-lg-6">
<div class="card">
<div class="card-body p-4">
<h2 class="titulo mb-4">Envie sua Mensagem</h2>
<form>
<div class="mb-3">
<label class="form-label fw-bold">Nome</label>
<input class="form-control" placeholder="Digite seu nome" type="text"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold">Email</label>
<input class="form-control" placeholder="Digite seu email" type="email"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold">Assunto</label>
<input class="form-control" placeholder="Digite o assunto" type="text"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold">Mensagem</label>
<textarea class="form-control" placeholder="Digite sua mensagem" rows="5"></textarea>
</div>
<button class="btn btn-enviar w-100 py-2">
                Enviar Mensagem
              </button>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- Footer -->
<footer class="text-white text-center py-4">
<p class="mb-0">© 2026 HQ Universe - Todos os direitos reservados.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>
</body>
</html>