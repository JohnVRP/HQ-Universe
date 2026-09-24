<?php

declare(strict_types=1);

require_once __DIR__ . '/foto_perfil.php';
require_once __DIR__ . '/conexao.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$siteFsRoot = dirname(__DIR__, 2);
$siteRoot = hqRaizUrl();
$projectUrl = $siteRoot . '/Projeto';
$nome = htmlspecialchars((string) ($_SESSION['nome'] ?? $_SESSION['usuario'] ?? 'usuário'), ENT_QUOTES, 'UTF-8');
$logado = !empty($_SESSION['valid']);
$admin = (($_SESSION['tipo'] ?? '') === 'admin');
$qtd = array_sum(array_map('intval', $_SESSION['carrinho'] ?? []));

garantirColunaFotoPerfil($pdo);
$fotoUsuario = null;

if ($logado && !empty($_SESSION['id'])) {
  try {
    $stFotoCabecalho = $pdo->prepare('SELECT foto FROM usuarios WHERE id = ?');
    $stFotoCabecalho->execute([(int) $_SESSION['id']]);
    $fotoUsuario = $stFotoCabecalho->fetchColumn() ?: null;
  } catch (Throwable $erroFotoCabecalho) {
    $fotoUsuario = null;
  }
}

if (!function_exists('hurl')) {
  function hurl(string $path): string { return url($path); }
}

if (!function_exists('himage')) {
  function himage(string $arquivo): string
  {
    global $siteFsRoot, $siteRoot;
    $arquivo = ltrim($arquivo, '/');

    foreach (['imagens', 'Imagens', 'Images'] as $pasta) {
      if (is_file($siteFsRoot . '/' . $pasta . '/' . $arquivo)) {
        return $siteRoot . '/' . $pasta . '/' . str_replace('%2F', '/', rawurlencode($arquivo));
      }
    }

    return $siteRoot . '/imagens/' . str_replace('%2F', '/', rawurlencode($arquivo));
  }
}

if (!function_exists('hproduct')) {
  function hproduct(array $candidatos, string $pesquisa): string
  {
    global $siteFsRoot, $siteRoot, $projectUrl;

    foreach ($candidatos as $candidato) {
      $candidato = ltrim($candidato, '/');
      if (is_file($siteFsRoot . '/' . $candidato)) {
        return url('../' . $candidato);
      }
    }

    return $projectUrl . '/pesquisa.php?q=' . rawurlencode($pesquisa);
  }
}
?>

<div class="hq-topo-wrap">
  <div class="hq-topo hq-container">
    <a class="hq-marca" href="<?= hurl('loja.php') ?>">
      <img src="<?= himage('logo_oficial.png') ?>" alt="HQ Universe" class="hq-logo">
    </a>

    <form class="hq-pesquisa" action="<?= hurl('pesquisa.php') ?>" method="get">
      <input type="search" name="q" placeholder="Pesquise por mangá ou HQ" aria-label="Pesquisar">
      <button type="submit">Pesquisar</button>
    </form>

    <div class="hq-acoes">
      <?php if ($logado): ?>
        <span class="hq-ola">Olá, <strong class="hq-nome-usuario"><?= $nome ?></strong></span>

        <button class="hq-mobile-toggle" type="button" aria-label="Abrir menu do usuário"
          aria-expanded="false">•••</button>

        <div class="hq-mobile-menu">
          <?php if ($admin): ?>
            <a class="hq-painel-admin" href="<?= hurl('Admin/index.php') ?>">Painel ADM</a>
          <?php endif; ?>

          <a class="hq-icone-acao hq-perfil-acao" href="<?= hurl('meuPerfil.php') ?>" aria-label="Abrir meu perfil"
            title="Meu perfil">
            <img class="hq-avatar" src="<?= htmlspecialchars(fotoPerfilUrl($fotoUsuario), ENT_QUOTES, 'UTF-8') ?>" alt="">
          </a>

          <?php if (!$admin): ?>
            <a class="hq-icone-acao hq-pedidos-acao" href="<?= hurl('meusPedidos.php') ?>" aria-label="Abrir meus pedidos"
              title="Meus Pedidos">
              <span class="hq-pedidos-icone" aria-hidden="true">📦</span>
            </a>
          <?php endif; ?>

          <a id="hq-carrinho-link" class="hq-icone-acao hq-carrinho-acao" href="<?= hurl('carrinho.php') ?>"
            aria-label="Abrir carrinho com <?= $qtd ?> item(ns)" title="Carrinho">
            <span class="hq-carrinho-icone" aria-hidden="true">🛒</span>
            <span id="hq-carrinho-qtd" class="hq-carrinho-badge"><?= $qtd ?></span>
          </a>

          <a class="hq-sair" href="<?= hurl('logout.php') ?>">Sair</a>
        </div>
      <?php else: ?>
        <button class="hq-mobile-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">•••</button>
        <div class="hq-mobile-menu">
          <a href="<?= hurl('login.php') ?>">Login</a>
          <a href="<?= hurl('registrar.php') ?>">Registrar-se</a>
          <a id="hq-carrinho-link" href="<?= hurl('carrinho.php') ?>">🛒 Carrinho (<span
              id="hq-carrinho-qtd"><?= $qtd ?></span>)</a>
        </div>
      <?php endif; ?>
    </div>

    <div id="hq-cart-toast" class="hq-cart-toast" role="status" aria-live="polite">
      <button type="button" class="hq-toast-fechar" aria-label="Fechar">×</button>
      <strong>Produto adicionado!</strong>
      <span id="hq-toast-texto"></span>
    </div>
  </div>

  <nav class="hq-categorias">
    <div class="hq-container hq-cat-inner">
      <div class="hq-menu-item">
        <a href="<?= hurl('Mangás.php') ?>">Mangás ▾</a>
        <div class="hq-submenu">
          <?php foreach ([
            'Naruto' => '../mangás/naruto.php',
            'One Piece' => '../mangás/onepiece.php',
            'Dragon Ball' => '../mangás/dragonball.php',
            'Bleach' => '../mangás/bleach.php',
            'Attack on Titan' => '../mangás/attack_on_titan.php',
            'Demon Slayer' => '../mangás/demonslayer.php',
            'Vinland Saga' => '../mangás/vinlandsaga.php',
            'Tokyo Ghoul' => '../mangás/tokyoghoul.php',
          ] as $n => $l): ?>
            <a href="<?= hurl($l) ?>"><?= htmlspecialchars($n, ENT_QUOTES, 'UTF-8') ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="hq-menu-item">
        <a href="<?= hurl('../marvel/marvel.php') ?>">Marvel ▾</a>
        <div class="hq-submenu">
          <?php foreach ([
            'Homem-Aranha' => '../marvel/spider.php',
            'Homem de Ferro' => '../marvel/iron_man.php',
            'Capitão América' => '../marvel/capitao_america.php',
            'Thor' => '../marvel/thor.php',
            'Hulk' => '../marvel/hulk.php',
            'Doutor Estranho' => '../marvel/doutor_estranho.php',
            'Vingadores' => '../marvel/vingadores.php',
            'Quarteto Fantástico' => '../marvel/quarteto.php',
          ] as $n => $l): ?>
            <a href="<?= hurl($l) ?>"><?= htmlspecialchars($n, ENT_QUOTES, 'UTF-8') ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="hq-menu-item">
        <a href="<?= hurl('../DC/DC.php') ?>">DC Comics ▾</a>
        <div class="hq-submenu">
          <?php foreach ([
            'Batman' => '../DC/batman.php',
            'Superman' => '../DC/superman.php',
            'Mulher-Maravilha' => '../DC/mulherMara.php',
            'Flash' => '../DC/flash.php',
            'Aquaman' => '../DC/aquaman.php',
            'Coringa' => '../DC/coringa.php',
            'Lanterna Verde' => '../DC/lanterna.php',
            'Liga da Justiça' => '../DC/ligadajustica.php',
            ] as $n => $l): ?>
            <a href="<?= hurl($l) ?>"><?= htmlspecialchars($n, ENT_QUOTES, 'UTF-8') ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </nav>
</div>

<script src="<?= hurl('../JS/carrinho-popup.js') ?>" defer></script>
<script src="<?= hurl('../JS/menu-mobile.js') ?>" defer></script>