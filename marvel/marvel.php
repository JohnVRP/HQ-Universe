<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Marvel | HQ Universe</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=62">
  <link rel="stylesheet" href="../CSS/funcionalidades.css?v=62">
</head>

<body>
  <?php require_once __DIR__ . '/../Projeto/Arquivos/cabecalho.php'; ?>

  <!-- MARVEL -->
  <section class="container_loja">
    <h2 class="titulo">Coleção Marvel</h2>
    <p class="subtitulo">Os clássicos do Universo Marvel</p>

    <div class="mangas-grid">

      <!-- HOMEM-ARANHA -->
      <div class="card_loja" id="produto-homem-aranha">
        <img class="img-ajustada" src="<?= himage('será.jpg') ?>" alt="Homem-Aranha">

        <div class="card-content_loja">
          <div class="categoria">Herói</div>

          <h3>Homem-Aranha</h3>

          <p class="descricao">
            Peter Parker protege Nova York usando seus poderes aracnídeos
            e seu senso de responsabilidade.
          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['marvel/spider.php'],
            'Homem-Aranha'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- HOMEM DE FERRO -->
      <div class="card_loja" id="produto-homem-de-ferro">
        <img class="img-ajustada" src="<?= himage('iron_1024.png') ?>" alt="Homem de Ferro">

        <div class="card-content_loja">
          <div class="categoria">Vingador</div>

          <h3>Homem de Ferro</h3>

          <p class="descricao">
            Tony Stark usa sua inteligência e armaduras avançadas para
            combater ameaças globais.
          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['marvel/iron_man.php'],
            'Homem de Ferro'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- CAPITÃO AMÉRICA -->
      <div class="card_loja" id="produto-capitao-america">
        <img class="img-ajustada" src="<?= himage('capitao_america.png') ?>" alt="Capitão América">

        <div class="card-content_loja">
          <div class="categoria">Vingador</div>

          <h3>Capitão América</h3>

          <p class="descricao">
            Steve Rogers representa coragem, liderança e justiça com seu
            lendário escudo.
          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['marvel/capitao_america.php'],
            'Capitão América'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- THOR -->
      <div class="card_loja" id="produto-thor">
        <img class="img-ajustada" src="<?= himage('thor_martelo.png') ?>" alt="Thor">

        <div class="card-content_loja">
          <div class="categoria">Deus do Trovão</div>

          <h3>Thor</h3>

          <p class="descricao">
            O poderoso deus nórdico protege os nove reinos utilizando o
            martelo Mjolnir.
          </p>

          <a class="btn_loja" href="<?= hproduct(['marvel/thor.php'], 'Thor') ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- HULK -->
      <div class="card_loja" id="produto-hulk">
        <img class="img-ajustada" src="<?= himage('hulk_logo.png') ?>" alt="Hulk">

        <div class="card-content_loja mt-4">
          <div class="categoria">Força Bruta</div>

          <h3 style="margin-top: 10px;">Hulk</h3>

          <p class="descricao">
            Bruce Banner se transforma em Hulk quando perde o controle de
            sua raiva.
          </p>

          <a class="btn_loja" href="<?= hproduct(['marvel/hulk.php'], 'Hulk') ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- DOUTOR ESTRANHO -->
      <div class="card_loja" id="produto-doutor-estranho">
        <img class="img-ajustada" src="<?= himage('doctor_logo.png') ?>" alt="Doutor Estranho">

        <div class="card-content_loja mt-4">
          <div class="categoria">Mago Supremo</div>

          <h3 style="margin-top: 10px;">Doutor Estranho</h3>

          <p class="descricao">
            Stephen Strange domina as artes místicas para proteger a
            realidade de ameaças mágicas.
          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['compra/doutor_estranho.php', 'marvel/doutor_estranho.php'],
            'Doutor Estranho'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- VINGADORES -->
      <div class="card_loja" id="produto-doutor-estranho">
        <img class="img-ajustada" src="<?= himage('vingadores_avante.png') ?>" alt="Doutor Estranho">

        <div class="card-content_loja mt-4">
          <div class="categoria">Equipe</div>

          <h3 style="margin-top: 10px;">VINGADORES</h3>

          <p class="descricao">
            Os Vingadores reúnem os maiores heróis da Marvel para enfrentar ameaças que nenhum deles conseguiria vencer
            sozinho.
          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['compra/doutor_estranho.php', 'marvel/vingadores.php'],
            'Doutor Estranho'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Quarteto-Fantástico -->
      <div class="card_loja" id="produto-doutor-estranho">
        <img class="img-ajustada" src="<?= himage('quarteto_logo.png') ?>" alt="Doutor Estranho">

        <div class="card-content_loja mt-4">
          <div class="categoria">Equipe</div>

          <h3 style="margin-top: 10px;">Quarteto Fantástico</h3>

          <p class="descricao">
            O Quarteto Fantástico é uma equipe de heróis da Marvel que ganhou poderes após uma missão espacial e enfrenta ameaças enquanto vive grandes aventuras em família.

          </p>

          <a class="btn_loja" href="<?= hproduct(
            ['compra/doutor_estranho.php', 'marvel/quarteto.php'],
            'Doutor Estranho'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>



    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <?php require_once __DIR__ . '/../Projeto/Arquivos/rodape.php'; ?>
</body>

</html>