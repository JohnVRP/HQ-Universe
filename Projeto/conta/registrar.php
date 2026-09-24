<?php
declare(strict_types=1);

require_once __DIR__ . '/../Arquivos/conexao_conta.php';

$mensagem = "";
$tipoAlerta = "info";
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $nome = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user = trim($_POST['username'] ?? '');
    $senha = $_POST['password'] ?? '';

    // Tipo do usuário
    $tipoUsuario = $_POST['tipo'] ?? 'cliente';

    // Permite apenas estes valores
    if (!in_array($tipoUsuario, ['cliente', 'admin'], true)) {
        $tipoUsuario = 'cliente';
    }

    $caminhoImagem = null;
    $uploadOK = true;

    // ===============================
    // Validação dos campos
    // ===============================

    if (empty($nome) || empty($email) || empty($user) || empty($senha)) {

        $mensagem = "Todos os campos devem ser preenchidos.";
        $tipoAlerta = "warning";
        $uploadOK = false;

    }

    // ===============================
    // Verifica usuário duplicado
    // ===============================

    if ($uploadOK) {

        try {

            $sqlCheck = "SELECT id, usuario, email
                         FROM usuarios
                         WHERE usuario = :usuario
                            OR email = :email";

            $stmtCheck = $strcon->prepare($sqlCheck);

            $stmtCheck->execute([
                ':usuario' => $user,
                ':email' => $email
            ]);

            $duplicado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($duplicado) {

                $uploadOK = false;
                $tipoAlerta = "danger";

                if ($duplicado['usuario'] === $user) {

                    $mensagem = "O nome de usuário <strong>@{$user}</strong> já está em uso.";

                } else {

                    $mensagem = "O e-mail <strong>{$email}</strong> já está cadastrado.";

                }

            }

        } catch (PDOException $e) {

            error_log($e->getMessage());

            $mensagem = "Erro ao verificar os dados.";

            $tipoAlerta = "danger";
            $uploadOK = false;

        }

    }

    // ===============================
    // Upload da imagem
    // ===============================

    if ($uploadOK && !empty($_FILES['arquivo']['name'])) {

        define("TAM_MAX", 2 * 1024 * 1024);

        $arquivo = $_FILES['arquivo'];

        $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if ($arquivo['size'] > TAM_MAX) {

            $mensagem = "Imagem maior que 2MB.";
            $tipoAlerta = "danger";
            $uploadOK = false;

        }

        if (!in_array($ext, $permitidas)) {

            $mensagem = "Formato inválido.";
            $tipoAlerta = "danger";
            $uploadOK = false;

        }

        if ($uploadOK) {

            $diretorioImagens = dirname(__DIR__) . '/imagens';

            if (!is_dir($diretorioImagens)) {
                mkdir($diretorioImagens, 0755, true);
            }

            $novoNome = uniqid("user_", true) . "." . $ext;

            $caminhoImagem = "imagens/" . $novoNome;
            $caminhoImagemFisico = dirname(__DIR__) . '/' . $caminhoImagem;

            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoImagemFisico)) {

                $mensagem = "Erro ao enviar a imagem.";

                $tipoAlerta = "danger";

                $uploadOK = false;

                $caminhoImagem = null;

            }

        }

    }

    // ===============================
    // Salvar usuário
    // ===============================

    if ($uploadOK) {

        try {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios
                    (
                        nome,
                        sobrenome,
                        email,
                        usuario,
                        senha,
                        tipo,
                        foto
                    )
                    VALUES
                    (
                        :nome,
                        :sobrenome,
                        :email,
                        :usuario,
                        :senha,
                        :tipo,
                        :foto
                    )";

            $stmt = $strcon->prepare($sql);

            $stmt->execute([

                ':nome' => $nome,
                ':sobrenome' => '',
                ':email' => $email,
                ':usuario' => $user,
                ':senha' => $senhaHash,
                ':tipo' => $tipoUsuario,
                ':foto' => $caminhoImagem

            ]);

            $mensagem = "Cadastro realizado com sucesso!";

            $tipoAlerta = "success";

            $sucesso = true;

        } catch (PDOException $e) {

            error_log($e->getMessage());

            if (
                $caminhoImagem &&
                file_exists(dirname(__DIR__) . '/' . $caminhoImagem)
            ) {
                unlink(dirname(__DIR__) . '/' . $caminhoImagem);
            }

            $mensagem = "Erro ao cadastrar usuário.";

            $tipoAlerta = "danger";

        }

    }

}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar-se | HQUniverse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
  <link rel="stylesheet" href="../../CSS/acesso.css?v=60">
</head>

<body class="bg-light py-5 pagina-acesso">

    <div class="container" style="max-width: 550px;">

        <div class="mb-3">
            <a href="../inicio.php" class="text-decoration-none text-secondary">
                ← Voltar para a Página Inicial
            </a>
        </div>

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="mb-0 h4">Criar Conta</h3>
            </div>

            <div class="card-body p-4">

                <?php if (!empty($mensagem)): ?>

                    <div class="alert alert-<?= htmlspecialchars($tipoAlerta) ?> shadow-sm">

                        <?= $mensagem ?>

                    </div>

                <?php endif; ?>

                <?php if ($sucesso): ?>

                    <div class="text-center">

                        <h5 class="text-success mb-3">
                            Cadastro realizado com sucesso!
                        </h5>

                        <div class="d-grid">

                            <a href="login.php" class="btn btn-success btn-lg">

                                Ir para o Login

                            </a>

                        </div>

                    </div>

                <?php else: ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">

                            <label for="name" class="form-label fw-semibold">
                                Nome Completo
                            </label>

                            <input type="text" id="name" name="name" class="form-control" required
                                value="<?= htmlspecialchars($nome ?? '') ?>" placeholder="Ex.: João da Silva">

                        </div>

                        <div class="mb-3">

                            <label for="email" class="form-label fw-semibold">
                                E-mail
                            </label>

                            <input type="email" id="email" name="email" class="form-control" required
                                value="<?= htmlspecialchars($email ?? '') ?>" placeholder="email@exemplo.com">

                        </div>

                        <div class="mb-3">

                            <label for="username" class="form-label fw-semibold">
                                Nome de Usuário
                            </label>

                            <input type="text" id="username" name="username" class="form-control" required
                                value="<?= htmlspecialchars($user ?? '') ?>" placeholder="usuario123">

                        </div>

                        <div class="mb-3">

                            <label for="password" class="form-label fw-semibold">
                                Senha
                            </label>

                            <input type="password" id="password" name="password" class="form-control" required
                                placeholder="Digite uma senha">

                        </div>

                        <div class="mb-3">

                            <label for="tipo" class="form-label fw-semibold">
                                Tipo de Usuário
                            </label>

                            <select id="tipo" name="tipo" class="form-select" required>

                                <option value="cliente" <?= (($tipoUsuario ?? 'cliente') === 'cliente') ? 'selected' : '' ?>>
                                    Cliente
                                </option>

                                <option value="admin" <?= (($tipoUsuario ?? '') === 'admin') ? 'selected' : '' ?>>
                                    Administrador
                                </option>

                            </select>

                        </div>

                        <div class="mb-4">

                            <label for="arquivo" class="form-label fw-semibold">
                                Foto de Perfil
                                <span class="text-muted small">(Opcional)</span>
                            </label>

                            <input type="file" id="arquivo" name="arquivo" class="form-control"
                                accept="image/png,image/jpeg,image/gif">

                            <div class="form-text">
                                Formatos permitidos: JPG, JPEG, PNG ou GIF (máx. 2MB).
                            </div>

                        </div>

                        <div class="d-grid">

                            <button type="submit" name="submit" class="btn btn-primary btn-lg fw-bold">

                                Cadastrar

                            </button>

                        </div>

                    </form>

                    <div class="text-center mt-4">

                        <p class="mb-0">

                            Já possui uma conta?

                            <a href="login.php" class="text-decoration-none text-primary">

                                Faça login

                            </a>

                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
