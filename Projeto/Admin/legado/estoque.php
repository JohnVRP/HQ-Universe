<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../Arquivos/conexao_conta.php';
require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../../conta/login.php");
    exit;
}

$mensagemStatus = "";

// =======================
// CADASTRAR PRODUTO
// =======================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nomeProduto = trim($_POST['nomeProduto'] ?? '');

    $qtd = filter_input(INPUT_POST, 'qtd', FILTER_VALIDATE_INT);

    $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

    if (
        empty($nomeProduto) ||
        $qtd === false ||
        $preco === false
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
            $mensagemStatus = "Produto cadastrado com sucesso!";

        } catch (PDOException $e) {
            if ($strcon->inTransaction()) {
                $strcon->rollBack();
            }

            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            $mensagemStatus = "Não foi possível cadastrar o produto.";
        }
    }
}

// =======================
// PESQUISA
// =======================

$pesquisa = trim($_GET['pesquisa'] ?? '');

if ($pesquisa !== '') {

    $sql = "SELECT
                p.id,
                p.nome AS nomeProduto,
                p.preco,
                COALESCE(e.quantidade, 0) AS qtd
            FROM produtos p
            LEFT JOIN estoque e ON e.produto_id = p.id
            WHERE p.nome LIKE :pesquisa
            ORDER BY p.id DESC";

    $stmt = $strcon->prepare($sql);

    $stmt->execute([
        ':pesquisa' => "%{$pesquisa}%"
    ]);

} else {

    $sql = "SELECT
                p.id,
                p.nome AS nomeProduto,
                p.preco,
                COALESCE(e.quantidade, 0) AS qtd
            FROM produtos p
            LEFT JOIN estoque e ON e.produto_id = p.id
            ORDER BY p.id DESC";

    $stmt = $strcon->prepare($sql);

    $stmt->execute();
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque | HQUniverse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .topo {
            background: #212529;
        }

        .card-header {
            background: #0d6efd;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .pesquisa {
            max-width: 420px;
            width: 100%;
        }

        .mensagem {
            background: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }
    </style>

    <link rel="stylesheet" href="../../../CSS/estilo_jvrp.css?v=41">
    <link rel="stylesheet" href="../../../CSS/funcionalidades.css?v=41">
</head>

<body class="pagina-admin">
    <nav class="navbar navbar-expand-lg navbar-dark topo shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                📚 HQUniverse
            </a>
            <div class="d-flex gap-2">
                <a href="index.php" class="btn btn-outline-light btn-sm">
                    Painel
                </a>
                <a href="AddProduto.php" class="btn btn-success btn-sm">
                    + Novo Produto
                </a>
                <a href="../../conta/logout.php" class="btn btn-danger btn-sm">
                    Sair
                </a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="card shadow border-0">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <span>Gerenciamento de Estoque</span>
                <form class="d-flex pesquisa" method="GET">
                    <input type="text" class="form-control" name="pesquisa" placeholder="Buscar produto..."
                        value="<?= htmlspecialchars($pesquisa ?? '') ?>">
                    <button class="btn btn-light ms-2" type="submit">
                        🔍
                    </button>
                </form>
            </div>
            <div class="card-body">
                <?php if (!empty($produtos) && count($produtos) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th width="180">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td>
                                            <?= (int) $produto['id']; ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($produto['nomeProduto']); ?>
                                        </td>
                                        <td>
                                            <?= (int) $produto['qtd']; ?>
                                        </td>
                                        <td>
                                            R$ <?= number_format((float) $produto['preco'], 2, ',', '.'); ?>
                                        </td>
                                        <td>
                                            <a href="editar.php?id=<?= (int) $produto['id']; ?>" class="btn btn-warning btn-sm">
                                                ✏ Editar
                                            </a>
                                            <a href="excluir.php?id=<?= (int) $produto['id']; ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirmarExclusao();">
                                                🗑 Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="mensagem">
                        <h5>Nenhum produto encontrado.</h5>
                        <p class="mb-0">
                            Cadastre um novo produto ou altere os filtros da pesquisa.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarExclusao() {
            return confirm(
                "Tem certeza que deseja excluir este produto?"
            );
        }
    </script>
    <?php require_once __DIR__ . '/../../Arquivos/rodape.php'; ?>
</body>

</html>