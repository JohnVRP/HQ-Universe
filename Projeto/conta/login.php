<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Arquivos/conexao_conta.php';

$mensagem = "";
$tipoAlerta = "danger";
$user = "";

/*
|--------------------------------------------------------------------------
| REDIRECIONAR QUEM JÁ ESTÁ LOGADO
|--------------------------------------------------------------------------
*/

if (
    isset($_SESSION['valid'], $_SESSION['tipo']) &&
    $_SESSION['valid'] === true
) {
    $tipoSessao = strtolower(trim((string) $_SESSION['tipo']));

    if (
        $tipoSessao === 'admin' ||
        $tipoSessao === 'administrador'
    ) {
        // login.php está dentro de Projeto, então volta uma pasta
        header("Location: ../Admin/index.php");
    } else {
        // inicio.php está na mesma pasta do login.php
        header("Location: ../loja.php");
    }

    exit;
}

/*
|--------------------------------------------------------------------------
| PROCESSAR LOGIN
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['submit'])
) {
    $user = trim($_POST['username'] ?? '');
    $senha = $_POST['password'] ?? '';

    if ($user === '' || $senha === '') {
        $mensagem = "Nome de usuário e senha devem ser preenchidos.";
        $tipoAlerta = "warning";
    } else {
        try {
            $sql = "SELECT
                        id,
                        nome,
                        usuario,
                        senha,
                        tipo
                    FROM usuarios
                    WHERE usuario = :usuario
                    LIMIT 1";

            $stmt = $strcon->prepare($sql);

            $stmt->execute([
                ':usuario' => $user
            ]);

            $linha = $stmt->fetch(PDO::FETCH_ASSOC);

            if (
                $linha !== false &&
                password_verify($senha, (string) $linha['senha'])
            ) {
                session_regenerate_id(true);

                $tipoUsuario = strtolower(trim((string) $linha['tipo']));

                $_SESSION['valid'] = true;
                $_SESSION['id'] = (int) $linha['id'];
                $_SESSION['name'] = (string) $linha['nome'];
                $_SESSION['nome'] = (string) $linha['nome'];
                $_SESSION['usuario'] = (string) $linha['usuario'];
                $_SESSION['tipo'] = $tipoUsuario;

                /*
                |--------------------------------------------------------------------------
                | REDIRECIONAMENTO POR TIPO
                |--------------------------------------------------------------------------
                */

                if ($tipoUsuario === 'admin') {
                    header("Location: ../Admin/index.php");
                } else {
                    header("Location: ../loja.php");
                }

                exit;
            }

            $mensagem = "Nome de usuário ou senha inválidos.";
            $tipoAlerta = "danger";
        } catch (PDOException $e) {
            error_log(
                "Erro no processo de login: " . $e->getMessage()
            );

            $mensagem = "Não foi possível realizar o login no momento. Tente novamente mais tarde.";
            $tipoAlerta = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | HQ Universe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
  <link rel="stylesheet" href="../../CSS/acesso.css?v=60">
</head>

<body class="bg-light py-5 pagina-acesso">

    <div class="container" style="max-width: 450px;">

        <div class="mb-3 text-center">

            <a href="../inicio.php" class="text-decoration-none text-secondary">

                ← Voltar para a página inicial
            </a>

        </div>

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center py-3">

                <h1 class="mb-0 h4">
                    Acesso ao Sistema
                </h1>

                <small>HQ Universe</small>

            </div>

            <div class="card-body p-4">

                <?php if ($mensagem !== ''): ?>

                    <div class="alert alert-<?= htmlspecialchars($tipoAlerta, ENT_QUOTES, 'UTF-8') ?> shadow-sm mb-4"
                        role="alert">

                        <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>

                    </div>

                <?php endif; ?>

                <form name="login" method="POST" action="">

                    <div class="mb-3">

                        <label for="username" class="form-label fw-semibold">

                            Nome de Usuário
                        </label>

                        <input type="text" id="username" name="username" class="form-control"
                            value="<?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?>" autocomplete="username" required
                            autofocus>

                    </div>

                    <div class="mb-4">

                        <div class="d-flex justify-content-between">

                            <label for="password" class="form-label fw-semibold">

                                Senha
                            </label>

                            <a href="recuperar_senha.php" class="text-decoration-none small text-muted">

                                Esqueceu a senha?
                            </a>

                        </div>

                        <input type="password" id="password" name="password" class="form-control"
                            autocomplete="current-password" required>

                    </div>

                    <div class="d-grid">

                        <button type="submit" name="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">

                            Entrar no Sistema
                        </button>

                    </div>

                </form>

                <div class="text-center mt-4">

                    <p class="mb-0 text-muted">

                        Não possui uma conta?

                        <a href="registrar.php" class="text-decoration-none" style="color: red;">

                            Cadastre-se aqui
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>