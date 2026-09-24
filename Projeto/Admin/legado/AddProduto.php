<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Arquivos/conexao_conta.php';
require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';

$mensagemStatus = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomeProduto = trim($_POST['nomeProduto'] ?? '');
    $qtd = filter_input(
        INPUT_POST,
        'qtd',
        FILTER_VALIDATE_INT
    );
    $preco = filter_input(
        INPUT_POST,
        'preco',
        FILTER_VALIDATE_FLOAT
    );
    if (
        empty($nomeProduto) ||
        $qtd === false ||
        $qtd < 0 ||
        $preco === false ||
        $preco < 0
    ) {
        $mensagemStatus = "Preencha todos os campos corretamente.";
    } else {
        try {
            $strcon->beginTransaction();

            $categoriaId = $strcon
                ->query("SELECT id FROM categorias ORDER BY id LIMIT 1")
                ->fetchColumn();

            if ($categoriaId === false) {
                $stmtCategoria = $strcon->prepare(
                    "INSERT INTO categorias (nome) VALUES (:nome)"
                );
                $stmtCategoria->execute([':nome' => 'Geral']);
                $categoriaId = (int) $strcon->lastInsertId();
            }

            $stmtProduto = $strcon->prepare(
                "INSERT INTO produtos
                    (categoria_id, nome, preco, ativo)
                 VALUES
                    (:categoria_id, :nome, :preco, 1)"
            );

            $stmtProduto->execute([
                ':categoria_id' => (int) $categoriaId,
                ':nome' => $nomeProduto,
                ':preco' => $preco
            ]);

            $produtoId = (int) $strcon->lastInsertId();

            $stmtEstoque = $strcon->prepare(
                "INSERT INTO estoque (produto_id, quantidade)
                 VALUES (:produto_id, :quantidade)"
            );

            $stmtEstoque->execute([
                ':produto_id' => $produtoId,
                ':quantidade' => $qtd
            ]);

            $strcon->commit();
            header("Location: AddProduto.php?sucesso=1");
            exit();

        } catch (PDOException $e) {
            if ($strcon->inTransaction()) {
                $strcon->rollBack();
            }

            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            $mensagemStatus = "Erro ao cadastrar o produto.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        fieldset {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 25px;
            background: #fff;
        }

        .container {
            max-width: 650px;
        }
    </style>

  <link rel="stylesheet" href="../../../CSS/estilo_jvrp.css?v=41">
  <link rel="stylesheet" href="../../../CSS/funcionalidades.css?v=41">
</head>

<body class="pagina-admin">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">
            Cadastro de Produtos
        </h2>
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Produto cadastrado com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($mensagemStatus)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensagemStatus) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <form method="POST">
            <fieldset>
                <legend class="fs-5 mb-3">
                    Dados do Produto
                </legend>
                <div class="mb-3">
                    <label class="form-label">
                        Nome do Produto
                    </label>
                    <input type="text" class="form-control" name="nomeProduto"
                        value="<?= htmlspecialchars($_POST['nomeProduto'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Quantidade
                    </label>
                    <input type="number" class="form-control" name="qtd" min="0"
                        value="<?= htmlspecialchars($_POST['qtd'] ?? '') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">
                        Preço
                    </label>
                    <input type="number" class="form-control" name="preco" step="0.01" min="0.01"
                        value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" type="submit">
                        Cadastrar Produto
                    </button>
                    <a href="estoque.php" class="btn btn-secondary">
                        Ver Produtos
                    </a>
                    <a href="index.php" class="btn btn-dark">
                        Painel Administrativo
                    </a>
                </div>
            </fieldset>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../../Arquivos/rodape.php'; ?>
</body>

</html>
