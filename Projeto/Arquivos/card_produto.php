<?php
declare(strict_types=1);
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/produtos.php';

/** Card compartilhado: dados e ID vêm do mesmo cadastro da página do produto. */
function hqCardProduto(PDO $pdo, int $codigo, array $opcoes = []): void
{
    $produto = hqProdutoPorCodigo($pdo, $codigo);
    if (!$produto) return;
    $classePreco = ($opcoes['classe_preco'] ?? '') === 'preco_index_2' ? 'preco_index_2' : 'preco_index';
    $disponivel = !empty($produto['id']) && $produto['estoque'] > 0;
    ?>
    <div class="card_index">
      <img alt="<?= e($produto['nome']) ?>" src="<?= e(url('../imagens/' . $produto['imagem'])) ?>">
      <div class="card-content_index">
        <div class="categoria"><?= e($opcoes['categoria'] ?? $produto['categoria']) ?></div>
        <h3 class="nomeproduto_index"><?= e($produto['nome']) ?></h3>
        <p class="<?= $classePreco ?>"><?= moeda((float) $produto['preco']) ?></p>
        <a class="comprar_index ver-mais" href="<?= e(hqUrlProduto($produto)) ?>">Ver Mais</a>
        <?php if ($opcoes['adicionar'] ?? true): ?>
          <form action="<?= e(url('carrinho_adicionar.php')) ?>" method="post">
            <input name="id" type="hidden" value="<?= (int) ($produto['id'] ?? 0) ?>">
            <input name="quantidade" type="hidden" value="1">
            <button class="comprar_index adicionar-carrinho" type="submit" <?= !$disponivel ? 'disabled' : '' ?>><?= $disponivel ? 'Adicionar ao Carrinho' : 'Indisponível' ?></button>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <?php
}
