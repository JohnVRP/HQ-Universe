<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Arquivos/conexao_conta.php';
require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';

$mensagemStatus = "";

// ===========================
// ATUALIZAR PRODUTO
// ===========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = filter_input(
        INPUT_POST,
        'id',
        FILTER_VALIDATE_INT
    );

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
        $id === false ||
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

            $stmtProduto = $strcon->prepare(
                "UPDATE produtos
                 SET nome = :nome, preco = :preco
                 WHERE id = :id"
            );

            $stmtProduto->execute([
                ':nome' => $nomeProduto,
                ':preco' => $preco,
                ':id' => $id
            ]);

            $stmtBuscaEstoque = $strcon->prepare(
                "SELECT id FROM estoque WHERE produto_id = :produto_id LIMIT 1"
            );
            $stmtBuscaEstoque->execute([':produto_id' => $id]);
            $estoqueId = $stmtBuscaEstoque->fetchColumn();

            if ($estoqueId === false) {
                $stmtEstoque = $strcon->prepare(
                    "INSERT INTO estoque (produto_id, quantidade)
                     VALUES (:produto_id, :quantidade)"
                );
                $stmtEstoque->execute([
                    ':produto_id' => $id,
                    ':quantidade' => $qtd
                ]);
            } else {
                $stmtEstoque = $strcon->prepare(
                    "UPDATE estoque
                     SET quantidade = :quantidade
                     WHERE id = :id"
                );
                $stmtEstoque->execute([
                    ':quantidade' => $qtd,
                    ':id' => (int) $estoqueId
                ]);
            }

            $strcon->commit();

            header("Location: estoque.php?editado=1");
            exit();

        } catch (PDOException $e) {
            if ($strcon->inTransaction()) {
                $strcon->rollBack();
            }

            error_log("Erro ao editar produto: " . $e->getMessage());
            $mensagemStatus = "Erro ao atualizar o produto.";
        }
    }
}

// ===========================
// BUSCAR PRODUTO
// ===========================

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);
if ($id === false || $id === null) {

    header("Location: estoque.php");
    exit();
}
try {
    $sql = "SELECT
                p.id,
                p.nome AS nomeProduto,
                p.preco,
                COALESCE(e.quantidade, 0) AS qtd
            FROM produtos p
            LEFT JOIN estoque e ON e.produto_id = p.id
            WHERE p.id = :id
            LIMIT 1";
    $stmt = $strcon->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);
    $produto = $stmt->fetch();
    if (!$produto) {
        header("Location: estoque.php");
        exit();
    }

} catch (PDOException $e) {
    error_log("Erro ao buscar produto: " . $e->getMessage());
    header("Location: estoque.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Produto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .card {
            max-width: 700px;
            margin: auto;
            margin-top: 50px;
            border: none;
            border-radius: 12px;
        }

        .card-header {
            background: #ffc107;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
    </style>

  <link rel="stylesheet" href="../../../CSS/estilo_jvrp.css?v=41">
  <link rel="stylesheet" href="../../../CSS/funcionalidades.css?v=41">
</head>

<body class="pagina-admin">

    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                Editar Produto
            </div>
            <div class="card-body">
                <?php if (!empty($mensagemStatus)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($mensagemStatus) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $produto['id']) ?>">
                    <div class="mb-3">
                        <label class="form-label">
                            Nome do Produto
                        </label>
                        <input type="text" class="form-control" name="nomeProduto"
                            value="<?= htmlspecialchars($produto['nomeProduto']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Quantidade
                        </label>
                        <input type="number" class="form-control" name="qtd" min="0"
                            value="<?= htmlspecialchars((string) $produto['qtd']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">
                            Preço
                        </label>
                        <input type="number" class="form-control" name="preco" step="0.01" min="0.01"
                            value="<?= htmlspecialchars((string) $produto['preco']) ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="estoque.php" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <a href="index.php" class="btn btn-dark">
                                Painel
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../../Arquivos/rodape.php'; ?>
</body>

</html>
