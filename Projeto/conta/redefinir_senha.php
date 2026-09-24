<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once __DIR__ . '/../Arquivos/conexao.php';

$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));

$erro = '';
$sucesso = false;
$usuario = null;

/*
|--------------------------------------------------------------------------
| VERIFICA O TOKEN
|--------------------------------------------------------------------------
*/

if (!preg_match('/^[a-f0-9]{64}$/', $token)) {

  $erro = 'Link de recuperação inválido ou incompleto.';

} else {

  $stmt = $pdo->prepare(
    'SELECT
            r.id,
            r.usuario_id,
            u.nome
         FROM recuperacoes_senha r
         INNER JOIN usuarios u
            ON u.id = r.usuario_id
         WHERE r.token_hash = ?
           AND r.usado_em IS NULL
           AND r.expira_em > NOW()
           AND u.ativo = 1
         LIMIT 1'
  );

  $stmt->execute([
    hash('sha256', $token)
  ]);

  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    $erro = 'Este link é inválido, já foi utilizado ou expirou.';
  }
}


/*
|--------------------------------------------------------------------------
| ALTERAÇÃO DA SENHA
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuario) {

  $senha = (string) ($_POST['senha'] ?? '');
  $confirmacao = (string) ($_POST['confirmacao'] ?? '');

  if (strlen($senha) < 6) {

    $erro = 'A nova senha precisa ter pelo menos 6 caracteres.';

  } elseif ($senha !== $confirmacao) {

    $erro = 'As senhas não coincidem.';

  } else {

    try {

      $pdo->beginTransaction();

      /*
       * Cria o hash seguro da nova senha.
       */
      $novoHash = password_hash(
        $senha,
        PASSWORD_DEFAULT
      );

      /*
       * Atualiza a senha do usuário.
       */
      $stmt = $pdo->prepare(
        'UPDATE usuarios
                 SET senha = ?
                 WHERE id = ?
                   AND ativo = 1'
      );

      $stmt->execute([
        $novoHash,
        (int) $usuario['usuario_id']
      ]);

      /*
       * Marca o token como utilizado.
       */
      $stmt = $pdo->prepare(
        'UPDATE recuperacoes_senha
                 SET usado_em = NOW()
                 WHERE id = ?'
      );

      $stmt->execute([
        (int) $usuario['id']
      ]);

      $pdo->commit();

      $sucesso = true;

    } catch (Throwable $e) {

      if ($pdo->inTransaction()) {
        $pdo->rollBack();
      }

      $erro = 'Não foi possível alterar a senha. Tente novamente.';
    }
  }
}
?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Nova senha | HQ Universe</title>


  <style>
    * {
      box-sizing: border-box;
    }


    body {

      margin: 0;

      min-height: 100vh;

      background: #f4f6f8;

      font-family:
        Arial,
        Helvetica,
        sans-serif;

      color: #111;

      display: flex;

      justify-content: center;

      align-items: flex-start;

      padding: 32px 16px;
    }


    .pagina {

      width: 100%;

      max-width: 426px;
    }


    .voltar {

      display: inline-block;

      margin:
        0 0 18px 8px;

      color: #55708c;

      text-decoration: none;

      font-size: 15px;
    }


    .voltar:hover {

      text-decoration: underline;
    }


    .caixa {

      width: 100%;

      background: #fff;

      border-radius: 6px;

      box-shadow:
        0 8px 24px rgba(0, 0, 0, 0.10);

      overflow: hidden;
    }


    /*
         * Cabeçalho azul
         */
    .topo {

      background: #1473ea;

      color: #fff;

      text-align: center;

      padding:
        17px 20px 19px;
    }


    .topo h1 {

      margin:
        0 0 4px;

      font-size: 25px;

      font-weight: 500;
    }


    .topo p {

      margin: 0;

      font-size: 15px;
    }


    .conteudo {

      padding:
        26px 24px 28px;
    }


    .intro {

      margin:
        0 0 20px;

      color: #555;

      line-height: 1.5;

      font-size: 15px;
    }


    label {

      display: block;

      margin:
        0 0 9px;

      font-weight: 700;

      font-size: 15px;
    }


    input {

      width: 100%;

      height: 48px;

      border:
        1px solid #d5dce3;

      border-radius: 6px;

      padding:
        0 13px;

      font-size: 15px;

      outline: none;

      margin-bottom: 17px;
    }


    input:focus {

      border-color: #1473ea;

      box-shadow:
        0 0 0 3px rgba(20, 115, 234, 0.12);
    }


    .botao {

      width: 100%;

      min-height: 48px;

      border: 0;

      border-radius: 6px;

      background: #1473ea;

      color: #fff;

      font-size: 17px;

      font-weight: 700;

      cursor: pointer;

      text-decoration: none;

      display: flex;

      align-items: center;

      justify-content: center;
    }


    .botao:hover {

      background: #0d63d0;
    }


    .mensagem {

      border-radius: 6px;

      padding:
        12px 13px;

      margin-bottom: 18px;

      font-size: 14px;

      line-height: 1.45;
    }


    .erro {

      background: #fff0f0;

      border:
        1px solid #efb5b5;

      color: #a00000;
    }


    .sucesso {

      background: #eef8f0;

      border:
        1px solid #b9dfbf;

      color: #245d2d;
    }


    .rodape {

      text-align: center;

      margin-top: 18px;

      font-size: 14px;
    }


    .rodape a {

      color: #55708c;

      text-decoration: none;
    }


    .rodape a:hover {

      text-decoration: underline;
    }


    @media (max-width: 480px) {

      body {

        padding:
          22px 12px;
      }


      .conteudo {

        padding:
          24px 20px 25px;
      }
    }
  </style>

</head>


<body>


  <main class="pagina">


    <a class="voltar" href="login.php">
      ← Voltar para o login
    </a>


    <section class="caixa">


      <header class="topo">

        <h1>
          Nova senha
        </h1>

        <p>
          HQ Universe
        </p>

      </header>


      <div class="conteudo">


        <?php if ($erro !== ''): ?>

          <div class="mensagem erro">

            <?= htmlspecialchars(
              $erro,
              ENT_QUOTES,
              'UTF-8'
            ) ?>

          </div>

        <?php endif; ?>


        <?php if ($sucesso): ?>


          <div class="mensagem sucesso">

            <strong>
              Senha alterada com sucesso!
            </strong>

            <br>

            Agora você já pode entrar
            no sistema usando sua nova senha.

          </div>


          <a class="botao" href="login.php">
            Ir para o login
          </a>


        <?php elseif ($usuario): ?>


          <p class="intro">

            Olá,

            <strong>
              <?= htmlspecialchars(
                (string) $usuario['nome'],
                ENT_QUOTES,
                'UTF-8'
              ) ?>
            </strong>.

            Digite sua nova senha abaixo.

          </p>


          <form method="post" action="">


            <input type="hidden" name="token" value="<?= htmlspecialchars(
              $token,
              ENT_QUOTES,
              'UTF-8'
            ) ?>">


            <label for="senha">

              Nova senha

            </label>


            <input type="password" id="senha" name="senha" minlength="6" autocomplete="new-password" required>


            <label for="confirmacao">

              Confirmar nova senha

            </label>


            <input type="password" id="confirmacao" name="confirmacao" minlength="6" autocomplete="new-password" required>


            <button class="botao" type="submit">
              Alterar senha
            </button>


          </form>


        <?php endif; ?>


        <div class="rodape">

          <a href="login.php">

            Voltar para o login

          </a>

        </div>


      </div>

    </section>

  </main>


</body>

</html>