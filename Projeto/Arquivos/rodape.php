<?php
require_once __DIR__ . '/funcoes.php';
if (!function_exists('hurl')) {
  function hurl(string $path): string { return url($path); }
}
?>
<section class="hq-newsletter">
  <div class="hq-newsletter-inner">
    <div>
      <h2>Receba Novidades</h2>
      <p>Promoções, novos volumes e lançamentos da HQ Universe no seu e-mail.</p>
    </div>
    <form id="hq-newsletter-form" action="<?= hurl('newsletter.php') ?>" method="post">
      <label class="visually-hidden" for="hq-newsletter-email">Seu e-mail</label>
      <input id="hq-newsletter-email" name="email" type="email" placeholder="Digite seu e-mail" required>
      <button type="submit">Quero receber</button>
      <span id="hq-newsletter-msg" aria-live="polite"></span>
    </form>
  </div>
</section>
<footer class="hq-rodape">
  <div class="hq-rodape-grid">
    <div class="hq-rodape-marca">
      <a class="hq-rodape-logo-link" href="<?= hurl('loja.php') ?>">
        <img class="hq-rodape-logo" src="<?= hurl('../imagens/logo_oficial.png') ?>" alt="HQ Universe">
      </a>

      <p>Quadrinhos, mangás e grandes histórias em um só universo.</p>

      <small>
        © 2026 HQ Universe. Todos os direitos reservados.
      </small>
    </div>
    <div>
      <h3>Suas Compras</h3>
      <a href="<?= hurl('login.php') ?>">Login / Registro</a>
      <a href="<?= hurl('prazos-entrega.php') ?>">Prazos de Entrega</a>
      <a href="<?= hurl('metodos-pagamento.php') ?>">Métodos de pagamento</a>
      <a href="<?= hurl('perguntas-frequentes.php') ?>">Perguntas frequentes</a>
    </div>
    <div>
      <h3>Serviços para Você</h3>
      <a href="<?= hurl('termos-condicoes.php') ?>">Termos e Condições</a>
      <a href="<?= hurl('regulamentos.php') ?>">Regulamentos</a>
      <a href="<?= hurl('politica-privacidade.php') ?>">Política de Privacidade</a>
      <a href="<?= hurl('politica-cookies.php') ?>">Política de Cookies</a>
    </div>
  </div>
</footer>
<script src="<?= hurl('../JS/newsletter.js') ?>" defer></script>