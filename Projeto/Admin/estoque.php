<?php

declare(strict_types=1);

require_once __DIR__ . '/../Arquivos/verificarAdmin.php';
require_once __DIR__ . '/../Arquivos/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['q'] ?? [] as $id => $quantidade) {
        $produtoId = filter_var($id, FILTER_VALIDATE_INT);
        $novaQuantidade = filter_var(
            $quantidade,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 0]]
        );

        if ($produtoId === false || $novaQuantidade === false) {
            continue;
        }

        $stmt = $pdo->prepare(
            'UPDATE estoque
             SET quantidade = ?
             WHERE produto_id = ?'
        );

        $stmt->execute([
            $novaQuantidade,
            $produtoId
        ]);
    }

    flash('sucesso', 'Estoque atualizado.');

    header('Location: estoque.php');
    exit;
}

$ps = $pdo->query(
    'SELECT
        p.id,
        p.nome,
        COALESCE(e.quantidade, 0) AS quantidade
     FROM produtos p
     LEFT JOIN estoque e
        ON e.produto_id = p.id
     ORDER BY p.nome'
)->fetchAll();
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <title>Estoque | Admin | HQ Universe</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap"
    rel="stylesheet"
  >

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="../../CSS/admin.css?v=61">
  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=61">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=61">
</head>

<body class="pagina-admin">

  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>

  <?php mostrarFlash(); ?>

  <main class="conteudo limite">

    <nav class="admin-menu">
      <a href="<?= url('Admin/index.php') ?>">Dashboard</a>
      <a href="<?= url('Admin/produtos.php') ?>">Produtos</a>
      <a href="<?= url('Admin/categorias.php') ?>">Categorias</a>
      <a href="<?= url('Admin/estoque.php') ?>">Estoque</a>
      <a href="<?= url('Admin/usuarios.php') ?>">Usuários</a>
      <a href="<?= url('Admin/pedidos.php') ?>">Pedidos</a>
      <a href="<?= url('loja.php') ?>">Ver loja</a>
    </nav>

    <h1>Estoque</h1>

    <form method="post" action="estoque.php" class="tabela-caixa">

      <table class="tabela">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($ps as $p): ?>
            <tr>
              <td><?= e($p['nome']) ?></td>

              <td>
                <input
                  type="number"
                  min="0"
                  name="q[<?= (int) $p['id'] ?>]"
                  value="<?= (int) $p['quantidade'] ?>"
                >
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <br>

      <button type="submit" class="botao">
        Salvar estoque
      </button>
    </form>

  </main>

  <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  ></script>
</body>

</html>
