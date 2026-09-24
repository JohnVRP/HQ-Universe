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
<title>Mangás | HQ Universe</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Bebas+Neue&amp;family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet"/>

  <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../CSS/funcionalidades.css?v=60">
</head>
<body>
  <?php require_once __DIR__ . '/Arquivos/cabecalho.php'; ?>
  


<!-- MANGÁS -->
<section class="container_loja">
<h2 class="titulo">Coleção Mangás</h2>
<p class="subtitulo">Os maiores sucessos do Universo dos Animes</p>
<div class="mangas-grid">
<!-- ONE PIECE -->
<div class="card_loja">
<img alt="One Piece" class="img-ajustada" src="../imagens/onepiece_ofc.jpg"/>
<div class="card-content_loja">
<div class="categoria">Aventura</div>
<h3>One Piece</h3>
<p class="descricao">
            Luffy e sua tripulação navegam pelos mares em busca do lendário tesouro One Piece.
          </p>
<a class="btn_loja" href="../Mangás/onepiece.php">Acessar</a>
</div>
</div>
<!-- NARUTO -->
<div class="card_loja">
<img alt="Naruto" class="img-ajustada" src="../imagens/naruto_logoofc.jpg"/>
<div class="card-content_loja">
<div class="categoria">Shounen</div>
<h3 style="margin-top: 10px;">Naruto</h3>
<p class="descricao">
            Naruto Uzumaki deseja se tornar Hokage e conquistar o respeito de sua vila.
          </p>
<a class="btn_loja" href="../Mangás/naruto.php">Acessar</a>
</div>
</div>
<!-- DEMON SLAYER -->
<div class="card_loja">
<img alt="Demon Slayer" src="../imagens/demonslayer.png"/>
<div class="card-content_loja">
<div class="categoria">Ação</div>
<h3 style="margin-top: 10px;">Demon Slayer</h3>
<p class="descricao">
            Tanjiro enfrenta demônios para salvar sua irmã Nezuko e vingar sua família.
          </p>
<a class="btn_loja" href="../Mangás/demonslayer.php">Acessar</a>
</div>
</div>
<!-- TOKYO GHOUL -->
<div class="card_loja">
<img alt="Tokyo Ghoul" src="../imagens/tokyo ghoul.jpg"/>
<div class="card-content_loja">
<div class="categoria">Seinen</div>
<h3 style="margin-top: 10px;">Tokyo Ghoul</h3>
<p class="descricao">
            Kaneki entra no sombrio mundo dos ghouls após um acidente que muda sua vida.
          </p>
<a class="btn_loja" href="../Mangás/tokyoghoul.php">Acessar</a>
</div>
</div>
<!-- DRAGON BALL -->
<div class="card_loja">
<img alt="Dragon Ball" src="../imagens/dragon_ball_laranjja.jpg"/>
<div class="card-content_loja mt-4">
<div class="categoria">Clássico</div>
<h3 style="margin-top: 10px;">Dragon Ball</h3>
<p class="descricao">
            Goku parte em aventuras épicas para encontrar as lendárias Esferas do Dragão.
          </p>
<a class="btn_loja" href="../Mangás/dragonball.php">Acessar</a>
</div>
</div>
<!-- BLEACH -->
<div class="card_loja">
<img alt="Bleach" src="../imagens/bleach_logo.jpg"/>
<div class="card-content_loja mt-4">
<div class="categoria">Sobrenatural</div>
<h3 style="margin-top: 10px;">Bleach</h3>
<p class="descricao">
            Ichigo Kurosaki recebe poderes de Soul Reaper e luta contra espíritos malignos.
          </p>
<a class="btn_loja" href="../Mangás/bleach.php">Acessar</a>
</div>
</div>
<!-- ATTACK ON TITAN -->
<div class="card_loja">
<img alt="Bleach" src="../imagens/Attack-on-Titan-Logo.png"/>
<div class="card-content_loja mt-4">
<div class="categoria">Shounen</div>
<h3 style="margin-top: 10px;">Attack on Titan</h3>
<p class="descricao">
            A humanidade luta contra os Titãs enquanto Eren busca vingança e liberdade.
          </p>
<a class="btn_loja" href="../Mangás/attack_on_titan.php">Acessar</a>
</div>
</div>
<!-- VINLAND SAGA -->
<div class="card_loja">
<img alt="Vinland" src="../imagens/vinland_saga.png"/>
<div class="card-content_loja mt-4">
<div class="categoria">Seinen</div>
<h3 style="margin-top: 10px;">Vinland Saga</h3>
<p class="descricao">
            Thorfinn embarca em uma jornada de vingança enquanto busca um verdadeiro significado para sua vida.
          </p>
<a class="btn_loja" href="../Mangás/vinlandsaga.php">Acessar</a>
</div>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>
</body>
</html>