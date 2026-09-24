<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Arquivos/foto_perfil.php';

require_once __DIR__ . '/../../Arquivos/conexao_conta.php';
require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';

$idUser = (int) $_SESSION['id'];

$erros = [];
$sucesso = false;
$mensagem = "";

// ===================================================
// BUSCAR DADOS DO USUÁRIO
// ===================================================

try {

    $sqlFetch = "
        SELECT
            nome,
            sobrenome,
            email,
            usuario,
            senha,
            foto,
            tipo
        FROM usuarios
        WHERE id = :id
    ";
    $stmtFetch = $strcon->prepare($sqlFetch);

    $stmtFetch->execute([
        ':id' => $idUser
    ]);
    $usuarioAtual = $stmtFetch->fetch();

    if (!$usuarioAtual) {
        header("Location: ../../conta/logout.php");
        exit();
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Erro ao carregar o cadastro.");
}
// ===================================================
// ATUALIZAR DADOS
// ===================================================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_cadastro"])) {
    $nome = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $user = trim($_POST["username"] ?? "");
    $senha = $_POST["password"] ?? "";
    $caminhoImagem = $usuarioAtual["foto"];

    if (empty($nome) || empty($email) || empty($user)) {
        $erros[] = "Preencha todos os campos obrigatórios.";
    }
    // =====================================
    // VERIFICAR DUPLICIDADE
    // =====================================

    if (empty($erros)) {

        $sqlCheck = "
            SELECT id
            FROM usuarios
            WHERE
            (
                usuario = :usuario
                OR
                email = :email
            )
            AND id <> :id
        ";
        $stmtCheck = $strcon->prepare($sqlCheck);

        $stmtCheck->execute([
            ':usuario' => $user,
            ':email' => $email,
            ':id' => $idUser
        ]);
        if ($stmtCheck->fetch()) {
            $erros[] = "Nome de usuário ou e-mail já estão em uso.";
        }
    }
    // =====================================
    // FOTO
    // =====================================

    if (empty($erros) && !empty($_FILES["arquivo"]["name"])) {
        $diretorioImagens = dirname(__DIR__, 2) . '/imagens';

        if (!is_dir($diretorioImagens)) {
            mkdir($diretorioImagens, 0755, true);
        }
        $arquivo = $_FILES["arquivo"];

        $extensao = strtolower(pathinfo(
            $arquivo["name"],
            PATHINFO_EXTENSION
        ));
        $permitidas = [
            "jpg",
            "jpeg",
            "png",
            "gif"
        ];
        if ($arquivo["size"] > 2 * 1024 * 1024) {
            $erros[] = "Imagem maior que 2MB.";
        } elseif (!in_array($extensao, $permitidas)) {
            $erros[] = "Formato inválido.";
        } else {

            $novoNome = uniqid("avatar_", true) . "." . $extensao;
            $novoCaminho = "imagens/" . $novoNome;
            $novoCaminhoFisico = dirname(__DIR__, 2) . '/' . $novoCaminho;
            if (
                move_uploaded_file(
                    $arquivo["tmp_name"],
                    $novoCaminhoFisico
                )
            ) {

                if (
                    !empty($usuarioAtual["foto"])
                    &&
                    file_exists(
                        dirname(__DIR__, 2) . '/' . $usuarioAtual["foto"]
                    )
                ) {
                    unlink(
                        dirname(__DIR__, 2) . '/' . $usuarioAtual["foto"]
                    );
                }
                $caminhoImagem = $novoCaminho;
            } else {
                $erros[] = "Erro ao enviar imagem.";
            }
        }
    }
    // =====================================
    // SALVAR
    // =====================================

    if (empty($erros)) {
        try {
            $hashSenha = !empty($senha)
                ? password_hash($senha, PASSWORD_DEFAULT)
                : $usuarioAtual["senha"];
            $sql = "
                UPDATE usuarios
                SET
                    nome = :nome,
                    email = :email,
                    usuario = :usuario,
                    senha = :senha,
                    foto = :foto
                WHERE id = :id
            ";

            $stmt = $strcon->prepare($sql);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':usuario' => $user,
                ':senha' => $hashSenha,
                ':foto' => $caminhoImagem,
                ':id' => $idUser
            ]);
            $_SESSION["nome"] = $nome;
            $_SESSION["valid"] = true;
            $_SESSION["usuario"] = $user;

            $usuarioAtual["nome"] = $nome;
            $usuarioAtual["email"] = $email;
            $usuarioAtual["usuario"] = $user;
            $usuarioAtual["foto"] = $caminhoImagem;

            $sucesso = true;
            $mensagem = "Cadastro atualizado com sucesso.";

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $erros[] = "Erro ao atualizar cadastro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Cadastro - Sistema Loja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../../../CSS/estilo_jvrp.css?v=41">
  <link rel="stylesheet" href="../../../CSS/funcionalidades.css?v=41">
  <link rel="stylesheet" href="../../../CSS/perfil.css?v=41">
</head>

<body class="bg-light pagina-perfil">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold text-info" href="index.php">
                🏪 Minha Loja
            </a>
            <div class="d-flex gap-2">
                <a href="index.php" class="btn btn-sm btn-outline-light">
                    Painel Inicial
                </a>
                <a href="estoque.php" class="btn btn-sm btn-primary">
                    📦 Meus Produtos
                </a>
                <a href="../../conta/logout.php" class="btn btn-sm btn-outline-danger">
                    Sair
                </a>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="h5 mb-0 fw-bold">
                            ⚙️ Gerenciar Meu Cadastro
                        </h3>
                    </div>
                    <div class="card-body p-4">

                        <!-- FOTO -->
                        <div class="text-center mb-4">
                            <?php if (
                                !empty($usuarioAtual['foto']) &&
                                file_exists(dirname(__DIR__, 2) . '/' . $usuarioAtual['foto'])
                            ): ?>
                                <img src="<?= e(url((string) $usuarioAtual['foto'])) ?>" alt="Foto de Perfil"
                                    class="img-thumbnail rounded-circle shadow-sm"
                                    style="width:120px;height:120px;object-fit:cover;">
                            <?php else: ?>
                                <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                                    style="width:120px;height:120px;font-size:3rem;">
                                    👤
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- SUCESSO -->
                        <?php if (!empty($sucesso)): ?>
                            <div class="alert alert-success shadow-sm text-center mb-4">
                                🎉 <?= htmlspecialchars($mensagem ?? '') ?>
                            </div>
                        <?php endif; ?>

                        <!-- ERROS -->
                        <?php if (!empty($erros)): ?>
                            <div class="alert alert-danger shadow-sm mb-4">
                                <h6 class="fw-bold">
                                    ⚠️ Atenção:
                                </h6>
                                <ul class="mb-0">
                                    <?php foreach ($erros as $erro): ?>
                                        <li><?= htmlspecialchars($erro) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form name="edicaoPerfil" method="POST" enctype="multipart/form-data">

                            <!-- NOME -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Nome Completo
                                </label>

                                <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST'
                                    ? ($nome ?? '')
                                    : ($usuarioAtual['nome'] ?? '')) ?>">

                            </div>

                            <!-- EMAIL -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Endereço de E-mail
                                </label>
                                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST'
                                    ? ($email ?? '')
                                    : ($usuarioAtual['email'] ?? '')) ?>">
                            </div>

                            <!-- LOGIN -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nome de Usuário
                                </label>
                                <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST'
                                    ? ($user ?? '')
                                    : ($usuarioAtual['usuario'] ?? '')) ?>">
                            </div>
                            <!-- SENHA -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nova Senha
                                    <span class="text-muted small">
                                        (Deixe em branco para manter a atual)
                                    </span>
                                </label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Digite apenas se desejar alterar">
                            </div>

                            <!-- FOTO -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Substituir Foto de Perfil
                                </label>
                                <input type="file" name="arquivo" class="form-control" accept="image/*">
                                <div class="form-text">
                                    JPG, PNG ou GIF (máx. 2MB)
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="update_cadastro" class="btn btn-primary btn-lg fw-bold">
                                    💾 Salvar Alterações
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    Voltar ao Menu
                                </a>
                            </div>
                        </form>
                        <hr class="my-4">

                        <!-- EXCLUIR CONTA -->
                        <div class="bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded p-3">
                            <h5 class="h6 text-danger fw-bold">
                                Excluir Conta
                            </h5>
                            <p class="small text-muted">
                                Deseja apagar definitivamente sua conta e todos os
                                os produtos cadastrados?
                            </p>
                            <a href="../../conta/encerrarConta.php" class="btn btn-outline-danger btn-sm fw-semibold">
                                Encerrar Conta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../../Arquivos/rodape.php'; ?>
</body>

</html>
