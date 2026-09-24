<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/Arquivos/conexao.php';
require_once __DIR__ . '/Arquivos/produtos.php';
$q = trim((string) ($_GET['q'] ?? ''));
$resultados = [];
if ($q !== '') {
    $termo = hqNormalizarProduto($q);
    foreach (hqTodosProdutos($pdo) as $produto) {
        $texto = hqNormalizarProduto(($produto['nome'] ?? '') . ' ' . ($produto['autor'] ?? '') . ' ' . ($produto['descricao'] ?? ''));
        if ($termo !== '' && str_contains($texto, $termo)) $resultados[] = $produto;
    }
    usort($resultados, fn(array $a, array $b): int => strnatcasecmp($a['nome'], $b['nome']));
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pesquisar | HQ Universe</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap"
    rel="stylesheet">

<link rel="stylesheet" href="../CSS/pesquisa.css?v=61">

  <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=61">
  <link rel="stylesheet" href="../CSS/funcionalidades.css?v=61">
</head>

<body class="pagina-pesquisa">
  <?php require_once __DIR__ . '/Arquivos/cabecalho.php'; ?>
  

  

  <main class="container_index pesquisa-pagina">

    <h1 class="titulo_index">
      Pesquisar Produtos
    </h1>

    <?php if ($q === ''): ?>

      <div class="pesquisa-vazia">
        <p>
          Digite o nome de um mangá ou HQ na barra de pesquisa.
        </p>
      </div>

    <?php elseif (!$resultados): ?>

      <div class="pesquisa-vazia">
        <p>
          Nenhum produto encontrado para
          <strong>“<?= e($q) ?>”</strong>.
        </p>
      </div>

    <?php else: ?>

      <p class="subtitulo pesquisa-subtitulo">
        <?= count($resultados) ?>
        resultado(s) para “<?= e($q) ?>”.
      </p>

      <div class="produtos_index pesquisa-grade">

        <?php foreach ($resultados as $produto): ?>

          <article class="card_index pesquisa-card">

            <img src="<?= url(
              '../imagens/' .
              rawurlencode((string) $produto['imagem'])
            ) ?>" alt="<?= e((string) $produto['nome']) ?>">

            <div class="card-content_index pesquisa-card-conteudo">

              <span class="categoria">
                <?= e((string) ($produto['categoria'] ?? 'Produto')) ?>
              </span>

              <h3 class="nomeproduto_index">
                <?= e((string) $produto['nome']) ?>
              </h3>

              <?php if (!empty($produto['autor'])): ?>
                <p class="pesquisa-autor">
                  <?= e((string) $produto['autor']) ?>
                </p>
              <?php endif; ?>

              <p class="preco_index pesquisa-preco">
                <?= moeda((float) $produto['preco']) ?>
              </p>

              <div class="pesquisa-acoes">

                <a class="comprar_index ver-mais" href="<?= e(hqUrlProduto($produto)) ?>">Ver Mais</a>

                <?php if ((int) ($produto['estoque'] ?? 0) > 0): ?>

                  <form action="carrinho/carrinho_adicionar.php" method="post" class="form-adicionar-pesquisa">

                    <input type="hidden" name="id" value="<?= (int) $produto['id'] ?>">

                    <input type="hidden" name="quantidade" value="1">

                    <button type="submit" class="comprar_index botao-adicionar-pesquisa adicionar-carrinho">Adicionar ao Carrinho</button>

                  </form>

                <?php else: ?>

                  <span class="produto-indisponivel">
                    Produto indisponível
                  </span>

                <?php endif; ?>

              </div>

            </div>

          </article>

        <?php endforeach; ?>

      </div>

    <?php endif; ?>

  </main>

  <?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>

</body>

</html>