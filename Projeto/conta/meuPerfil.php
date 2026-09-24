<?php

declare(strict_types=1);

require_once __DIR__ . '/../Arquivos/verificarLogin.php';
require_once __DIR__ . '/../Arquivos/conexao.php';
require_once __DIR__ . '/../Arquivos/funcoes.php';
require_once __DIR__ . '/../Arquivos/foto_perfil.php';

garantirColunaFotoPerfil($pdo);

$usuarioId = (int) $_SESSION['id'];

$stUsuario = $pdo->prepare(
    'SELECT id, nome, sobrenome, email, usuario, telefone, foto, tipo
     FROM usuarios
     WHERE id = ?'
);
$stUsuario->execute([$usuarioId]);
$u = $stUsuario->fetch();

if (!$u) {
    header('Location: logout.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = trim((string) ($_POST['nome'] ?? ''));
        $sobrenome = trim((string) ($_POST['sobrenome'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $usuario = trim((string) ($_POST['usuario'] ?? ''));
        $telefone = trim((string) ($_POST['telefone'] ?? ''));
        $senha = (string) ($_POST['senha'] ?? '');

        if ($nome === '' || $email === '' || $usuario === '') {
            throw new RuntimeException('Preencha nome, e-mail e usuário.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Informe um e-mail válido.');
        }

        $stDuplicado = $pdo->prepare(
            'SELECT id
             FROM usuarios
             WHERE (email = ? OR usuario = ?)
               AND id <> ?
             LIMIT 1'
        );
        $stDuplicado->execute([$email, $usuario, $usuarioId]);

        if ($stDuplicado->fetch()) {
            throw new RuntimeException('O e-mail ou nome de usuário já está em uso.');
        }

        $novaFoto = salvarFotoPerfil(
            $_FILES['foto'] ?? [],
            $usuarioId,
            $u['foto'] ?? null
        );

        $sql = 'UPDATE usuarios
                SET nome = ?,
                    sobrenome = ?,
                    email = ?,
                    usuario = ?,
                    telefone = ?';

        $parametros = [$nome, $sobrenome, $email, $usuario, $telefone];

        if ($novaFoto !== null) {
            $sql .= ', foto = ?';
            $parametros[] = $novaFoto;
        }

        if ($senha !== '') {
            if (mb_strlen($senha) < 6) {
                throw new RuntimeException('A nova senha deve ter pelo menos 6 caracteres.');
            }

            $sql .= ', senha = ?';
            $parametros[] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $sql .= ' WHERE id = ?';
        $parametros[] = $usuarioId;

        $pdo->prepare($sql)->execute($parametros);

        $_SESSION['nome'] = $nome;
        $_SESSION['usuario'] = $usuario;

        flash('sucesso', 'Perfil atualizado com sucesso.');
        header('Location: meuPerfil.php');
        exit;
    } catch (RuntimeException $erro) {
        flash('erro', $erro->getMessage());
    } catch (Throwable $erro) {
        error_log($erro->getMessage());
        flash('erro', 'Não foi possível atualizar o perfil.');
    }

    $stUsuario->execute([$usuarioId]);
    $u = $stUsuario->fetch();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Meu Perfil | HQ Universe</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap"
    rel="stylesheet"
  >


  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
  <link rel="stylesheet" href="../../CSS/perfil.css?v=60">
</head>

<body class="pagina-perfil">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  
  
  <?php mostrarFlash(); ?>

  <main class="conteudo limite">
    <form class="formulario perfil-formulario" method="post" enctype="multipart/form-data">
      <div class="perfil-titulo">
        <h1>Meu Perfil</h1>

        <?php if (($u['tipo'] ?? '') === 'admin'): ?>
          <span class="perfil-tipo">Administrador</span>
        <?php endif; ?>
      </div>

      <section class="perfil-foto-area">
        <img
          class="perfil-avatar"
          src="<?= e(fotoPerfilUrl($u['foto'] ?? null)) ?>"
          alt="Foto de perfil de <?= e($u['nome'] ?: $u['usuario']) ?>"
        >

        <div class="perfil-foto-controles">
          <label for="foto">Alterar foto do perfil</label>
          <input
            id="foto"
            name="foto"
            type="file"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
          >
          <small>JPG, PNG ou WEBP, com no máximo 2 MB.</small>
        </div>
      </section>

      <div class="form-grid">
        <?php
        $campos = [
            'nome' => ['Nome', 'text'],
            'sobrenome' => ['Sobrenome', 'text'],
            'email' => ['E-mail', 'email'],
            'usuario' => ['Usuário', 'text'],
            'telefone' => ['Telefone', 'text'],
        ];
        ?>

        <?php foreach ($campos as $campo => [$rotulo, $tipo]): ?>
          <div class="campo">
            <label for="<?= e($campo) ?>"><?= e($rotulo) ?></label>
            <input
              id="<?= e($campo) ?>"
              type="<?= e($tipo) ?>"
              name="<?= e($campo) ?>"
              value="<?= e((string) ($u[$campo] ?? '')) ?>"
              <?= in_array($campo, ['nome', 'email', 'usuario'], true) ? 'required' : '' ?>
            >
          </div>
        <?php endforeach; ?>

        <div class="campo">
          <label for="senha">Nova senha (opcional)</label>
          <input id="senha" type="password" name="senha" minlength="6">
        </div>
      </div>

      <div class="perfil-acoes">
        <button class="botao" type="submit">Salvar alterações</button>

        <?php if (($u['tipo'] ?? '') === 'admin'): ?>
          <a class="perfil-excluir-conta" href="encerrarConta.php">
            Excluir conta
          </a>
        <?php endif; ?>
      </div>
    </form>
  </main>

  <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>
</body>
</html>
