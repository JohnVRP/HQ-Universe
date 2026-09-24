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
  <title>DC Comics | HQ Universe</title>

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

  <section class="container_loja">
    <h2 class="titulo">Coleção DC</h2>
    <p class="subtitulo">Os clássicos do Universo DC</p>

    <div class="mangas-grid">

      <!-- X-MEN -->
      <div class="card_loja" id="produto-batman">
        <img class="img-ajustada" src="<?= himage('batman_logo.png') ?>" alt="Batman">
        <div class="card-content_loja">
          <div class="categoria">Herói</div>
          <h3>Batman</h3>
          <p class="descricao">
            Bruce Wayne combate o crime em Gotham City utilizando inteligência,
            tecnologia e treinamento.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/batman.php'],
            'Batman'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Superman -->
      <div class="card_loja" id="produto-superman">
        <img class="img-ajustada" src="<?= himage('superman_logo.png') ?>" alt="Superman">
        <div class="card-content_loja">
          <div class="categoria">Kriptoniano</div>
          <h3>Superman</h3>
          <p class="descricao">
            Clark Kent usa seus poderes extraordinários para proteger a Terra
            e defender a justiça.
          </p>
           <a class="btn_loja" href="<?= hproduct(
            ['DC/superman.php'],
            'Superman'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Mulher-Maravilha -->
      <div class="card_loja" id="produto-mulher-maravilha">
        <img class="img-ajustada" src="<?= himage('mulher_maravilha_logo.png') ?>" alt="Mulher-Maravilha">
        <div class="card-content_loja">
          <div class="categoria">Amazona</div>
          <h3>Mulher-Maravilha</h3>
          <p class="descricao">
            Diana Prince é uma guerreira amazona que luta pela paz e pela verdade.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/mulherMara.php'],
            'Mulher-Maravilha'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Flash -->
      <div class="card_loja" id="produto-flash">
        <img class="img-ajustada" src="<?= himage('flash_logo.png') ?>" alt="Flash">
        <div class="card-content_loja">
          <div class="categoria">Velocista</div>
          <h3>Flash</h3>
          <p class="descricao">
            Barry Allen possui super velocidade e protege Central City contra ameaças.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/flash.php'],
            'Flash'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Aquaman -->
      <div class="card_loja" id="produto-aquaman">
        <img class="img-ajustada" src="<?= himage('aquaman_logo.png') ?>" alt="Aquaman">
        <div class="card-content_loja mt-4">
          <div class="categoria">Atlante</div>
          <h3 style="margin-top: 10px;">Aquaman</h3>
          <p class="descricao">
            Arthur Curry governa Atlantis e protege os oceanos e o mundo da superfície.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/aquaman.php'],
            'Aquaman'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>


      <!-- Coringa -->
      <div class="card_loja" id="produto-coringa">
        <img class="img-ajustada" src="<?= himage('coringa_logo.png') ?>" alt="Coringa">
        <div class="card-content_loja mt-4">
          <div class="categoria">Vilão</div>
          <h3 style="margin-top: 10px;">Coringa</h3>
          <p class="descricao">
            O maior inimigo do Batman é conhecido por seu caos, loucura
            e crimes imprevisíveis.
          </p>
         <a class="btn_loja" href="<?= hproduct(
            ['DC/coringa.php'],
            'Coringa'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Lanterna verde -->
      <div class="card_loja" id="produto-coringa">
        <img class="img-ajustada" src="<?= himage('lanterna_logo.png') ?>" alt="Coringa">
        <div class="card-content_loja mt-4">
          <div class="categoria">Herói Cósmico</div>
          <h3 style="margin-top: 10px;">Lanterna Verde</h3>
          <p class="descricao">
            Hal Jordan utiliza o anel do poder para proteger o universo como um dos maiores Lanternas Verdes.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/lanterna.php'],
            'Lanterna Verde'
          ) ?>">
            Acessar
          </a>
        </div>
      </div>

      <!-- Liga da justiça-->
      <div class="card_loja" id="produto-coringa">
        <img class="img-ajustada" src="<?= himage('liga_logo.png') ?>" alt="Coringa">
        <div class="card-content_loja mt-4">
          <div class="categoria">Supergrupo</div>
          <h3 style="margin-top: 10px;">Liga da Justiça</h3>
          <p class="descricao">
            Os maiores heróis da Terra unem forças para enfrentar ameaças que nenhum deles venceria sozinho.
          </p>
          <a class="btn_loja" href="<?= hproduct(
            ['DC/ligadajustica.php'],
            'Liga da Justiça'
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