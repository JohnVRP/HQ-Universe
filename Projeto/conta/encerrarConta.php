<?php

declare(strict_types=1);

require_once __DIR__ . '/../Arquivos/verificarLogin.php';
require_once __DIR__ . '/../Arquivos/conexao.php';
require_once __DIR__ . '/../Arquivos/funcoes.php';

$usuarioId = (int) ($_SESSION['id'] ?? 0);
$tipoUsuario = (string) ($_SESSION['tipo'] ?? '');

if ($tipoUsuario !== 'admin') {
    flash('erro', 'A exclusão de conta nesta tela está disponível somente para administradores.');
    header('Location: meuPerfil.php');
    exit;
}

$stUsuario = $pdo->prepare('SELECT id, nome, usuario, foto, tipo FROM usuarios WHERE id = ? LIMIT 1');
$stUsuario->execute([$usuarioId]);
$usuario = $stUsuario->fetch();

if (!$usuario) {
    header('Location: logout.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['confirmacao'])) {
            throw new RuntimeException('Confirme que está ciente antes de excluir a conta.');
        }

        $totalAdmins = (int) $pdo
            ->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin' AND ativo = 1")
            ->fetchColumn();

        if ($totalAdmins <= 1) {
            throw new RuntimeException(
                'Não é possível excluir o único administrador ativo. Cadastre ou promova outro administrador primeiro.'
            );
        }

        $stPedidos = $pdo->prepare('SELECT COUNT(*) FROM pedidos WHERE usuario_id = ?');
        $stPedidos->execute([$usuarioId]);

        if ((int) $stPedidos->fetchColumn() > 0) {
            throw new RuntimeException(
                'Esta conta possui pedidos vinculados e não pode ser excluída diretamente. '
                . 'Mantenha-a para preservar o histórico da loja.'
            );
        }

        $foto = trim((string) ($usuario['foto'] ?? ''));

        $pdo->beginTransaction();
        $pdo->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$usuarioId]);
        $pdo->commit();

        if ($foto !== '' && str_starts_with($foto, 'uploads/perfis/')) {
            $arquivoFoto = dirname(__DIR__) . '/' . $foto;
            if (is_file($arquivoFoto)) {
                @unlink($arquivoFoto);
            }
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                (bool) $params['secure'],
                (bool) $params['httponly']
            );
        }

        session_destroy();
        header('Location: registrar.php?status=conta_encerrada');
        exit;
    } catch (RuntimeException $erro) {
        flash('erro', $erro->getMessage());
    } catch (Throwable $erro) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log($erro->getMessage());
        flash('erro', 'Não foi possível excluir a conta no momento.');
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Excluir Conta | HQ Universe</title>

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
    <section class="painel excluir-conta-painel">
      <header class="excluir-conta-cabecalho">
        <span class="excluir-conta-icone" aria-hidden="true">⚠️</span>
        <div>
          <h1>Excluir conta administrativa</h1>
          <p>Esta ação remove permanentemente o cadastro quando não existem vínculos que precisem ser preservados.</p>
        </div>
      </header>

      <div class="excluir-conta-aviso">
        <h2>Antes de continuar</h2>
        <ul>
          <li>Não é possível excluir o único administrador ativo.</li>
          <li>Contas com pedidos vinculados precisam ser preservadas para manter o histórico.</li>
          <li>A foto de perfil será removida do servidor.</li>
          <li>A sessão será encerrada imediatamente após a exclusão.</li>
        </ul>
      </div>

      <form method="post" class="excluir-conta-form">
        <label class="excluir-conta-confirmacao">
          <input type="checkbox" name="confirmacao" value="1" required>
          <span>Estou ciente de que esta ação é definitiva e não poderá ser desfeita.</span>
        </label>

        <div class="excluir-conta-acoes">
          <a class="botao-secundario" href="meuPerfil.php">Cancelar</a>
          <button
            class="perfil-excluir-conta"
            type="submit"
            onclick="return confirm('Tem certeza que deseja excluir definitivamente esta conta?');"
          >
            Excluir definitivamente
          </button>
        </div>
      </form>
    </section>
  </main>

  <?php require_once __DIR__ . '/../Arquivos/rodape.php'; ?>
</body>
</html>
