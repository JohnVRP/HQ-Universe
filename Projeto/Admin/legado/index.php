<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';
require_once __DIR__ . '/../../Arquivos/conexao_conta.php';

try {
    $sql = "SELECT
                    id,
                    nome,
                    email,
                    usuario,
                    foto
                FROM usuarios
                WHERE id = :id
                LIMIT 1";
    $stmt = $strcon->prepare($sql);

    $stmt->bindValue(
        ':id',
        (int) $_SESSION['id'],
        PDO::PARAM_INT
    );
    $stmt->execute();
    $usuarioAtual = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log(
        "Erro ao carregar usuário: " .
        $e->getMessage()
    );
    $usuarioAtual = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Painel Administrativo | HQUniverse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../../CSS/estilo_jvrp.css?v=41">
    <link rel="stylesheet" href="../../../CSS/funcionalidades.css?v=41">
</head>

<body class="bg-light d-flex flex-column min-vh-100 pagina-admin">

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold" href="index.php">
                📚 HQUniverse
            </a>

            <?php if (isset($_SESSION['valid'])): ?>

                <div class="d-flex align-items-center gap-2">

                    <a href="../../inicio.php" class="btn btn-outline-light btn-sm">
                        Ver Loja
                    </a>

                    <a href="../../conta/logout.php" class="btn btn-danger btn-sm">
                        Sair
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </nav>

    <!-- CONTEÚDO -->
    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            Painel Administrativo
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['valid'])): ?>
                            <div class="text-center mb-4">
                                <?php if (
                                    !empty($usuarioAtual['foto']) &&
                                    file_exists(dirname(__DIR__, 2) . '/' . $usuarioAtual['foto'])
                                ): ?>
                                    <img src="<?= e(url((string) $usuarioAtual['foto'])) ?>"
                                        class="rounded-circle shadow" style="width:120px;height:120px;object-fit:cover;"
                                        alt="Foto">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center shadow"
                                        style="width:120px;height:120px;font-size:3rem;">
                                        👤
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-success text-center">
                                Bem-vindo,
                                <strong>
                                    <?= htmlspecialchars($_SESSION['nome'] ?? 'Administrador'); ?>
                                </strong>
                            </div>
                            <div class="row text-center mb-4">
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <h6>Nome</h6>
                                        <strong>
                                            <?= htmlspecialchars($usuarioAtual['nome'] ?? '-') ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <h6>Usuário</h6>
                                        <strong>
                                            <?= htmlspecialchars($usuarioAtual['usuario'] ?? '-') ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3">
                                        <h6>E-mail</h6>
                                        <strong>
                                            <?= htmlspecialchars($usuarioAtual['email'] ?? '-') ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-3">
                                <a href="estoque.php" class="btn btn-outline-primary btn-lg">
                                    📦 Gerenciar Produtos
                                </a>
                                <a href="AddProduto.php" class="btn btn-outline-success btn-lg">
                                    Cadastrar produto
                                </a>
                                <a href="editarCadastro.php" class="btn btn-outline-secondary btn-lg">
                                    👤 Meu Cadastro
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                Você precisa fazer login para acessar o painel.
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="../../conta/login.php" class="btn btn-primary">
                                    Entrar
                                </a>
                                <a href="../../conta/registrar.php" class="btn btn-outline-dark">
                                    Criar Conta
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- RODAPÉ -->
    <footer class="bg-dark text-light text-center py-3 mt-auto">
        <div class="container">
            <small>
                © <?= date('Y') ?> HQUniverse — Painel Administrativo.
            </small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php require_once __DIR__ . '/../../Arquivos/rodape.php'; ?>
</body>

</html>
