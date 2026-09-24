<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../Arquivos/conexao.php';

$erro = '';
$sucesso = '';
$linkTeste = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $identificador = trim((string)($_POST['identificador'] ?? ''));

    if ($identificador === '') {

        $erro = 'Informe seu e-mail ou nome de usuário.';

    } else {

        // IMPORTANTE:
        // Usamos dois parâmetros diferentes (:email e :usuario)
        // porque o PDO pode apresentar erro HY093 quando
        // o mesmo parâmetro nomeado é usado mais de uma vez.

        $stmt = $pdo->prepare(
            'SELECT id, nome
             FROM usuarios
             WHERE ativo = 1
               AND (email = :email OR usuario = :usuario)
             LIMIT 1'
        );

        $stmt->execute([
            'email' => $identificador,
            'usuario' => $identificador
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mensagem genérica para não revelar
        // se o cadastro existe ou não.
        $sucesso = 'Se os dados informados estiverem cadastrados, um link de recuperação foi gerado.';

        if ($usuario) {

            // Gera um token aleatório seguro.
            $token = bin2hex(random_bytes(32));

            // Salva apenas o hash do token no banco.
            $tokenHash = hash('sha256', $token);

            // Invalida pedidos anteriores ainda não utilizados.
            $stmt = $pdo->prepare(
                'UPDATE recuperacoes_senha
                 SET usado_em = NOW()
                 WHERE usuario_id = ?
                   AND usado_em IS NULL'
            );

            $stmt->execute([
                (int)$usuario['id']
            ]);

            // Token válido por 30 minutos.
            $stmt = $pdo->prepare(
                'INSERT INTO recuperacoes_senha
                 (usuario_id, token_hash, expira_em)
                 VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 MINUTE))'
            );

            $stmt->execute([
                (int)$usuario['id'],
                $tokenHash
            ]);

            /*
             * Gera o link para a página de redefinição.
             *
             * Como o arquivo atual é recuperar_senha.php,
             * dirname() pega a pasta onde ele está localizado.
             */

            $pastaProjeto = rtrim(
                dirname($_SERVER['SCRIPT_NAME'] ?? '/Projeto/recuperar_senha.php'),
                '/'
            );

            $linkTeste = $pastaProjeto .
                '/redefinir_senha.php?token=' .
                urlencode($token);
        }
    }
}
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Recuperar senha | HQ Universe</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin-top: 20px;
            min-height: 100vh;
            background: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
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
            margin: 0 0 18px 8px;
            color: #55708c;
            text-decoration: none;
            font-size: 15px;
        }

        .voltar:hover {
            text-decoration: underline;
        }

        .caixa {
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 8px 24px rgba(0,0,0,.10);
            overflow: hidden;
        }

        .topo {
            background: #1473ea;
            color: #fff;
            text-align: center;
            padding: 17px 20px 19px;
        }

        .topo h1 {
            margin: 0 0 4px;
            font-size: 25px;
            font-weight: 500;
        }

        .topo p {
            margin: 0;
            font-size: 15px;
        }

        .conteudo {
            padding: 26px 24px 28px;
        }

        .intro {
            margin: 0 0 20px;
            color: #555;
            line-height: 1.5;
            font-size: 15px;
        }

        label {
            display: block;
            margin: 0 0 9px;
            font-weight: 700;
            font-size: 15px;
        }

        input {
            width: 100%;
            height: 48px;
            border: 1px solid #d5dce3;
            border-radius: 6px;
            padding: 0 13px;
            font-size: 15px;
            outline: none;
            margin-bottom: 17px;
        }

        input:focus {
            border-color: #1473ea;
            box-shadow: 0 0 0 3px rgba(20,115,234,.12);
        }

        .botao {
            width: 100%;
            height: 48px;
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
            padding: 12px 13px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.45;
        }

        .erro {
            background: #fff0f0;
            border: 1px solid #efb5b5;
            color: #a00000;
        }

        .sucesso {
            background: #eef8f0;
            border: 1px solid #b9dfbf;
            color: #245d2d;
        }

        .teste {
            margin-top: 14px;
            padding: 13px;
            border-radius: 6px;
            background: #f7f7f7;
            border: 1px solid #ddd;
            font-size: 13px;
            line-height: 1.45;
            word-break: break-word;
        }

        .teste a {
            color: #1473ea;
            font-weight: 700;
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

        @media (max-width: 480px) {

            body {
                padding: 22px 12px;
            }

            .conteudo {
                padding: 24px 20px 25px;
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

            <h1>Recuperar senha</h1>

            <p>HQ Universe</p>

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


            <?php if ($sucesso !== ''): ?>

                <div class="mensagem sucesso">

                    <?= htmlspecialchars(
                        $sucesso,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </div>


                <?php if ($linkTeste !== ''): ?>

                    <div class="teste">

                        <strong>
                            Link de teste local:
                        </strong>

                        <br>

                        <a href="<?= htmlspecialchars(
                            $linkTeste,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>">

                            Abrir redefinição de senha

                        </a>

                    </div>

                <?php endif; ?>


            <?php else: ?>

                <p class="intro">

                    Informe o e-mail ou nome de usuário
                    cadastrado para recuperar sua senha.

                </p>


                <form method="post" action="">

                    <label for="identificador">
                        E-mail ou nome de usuário
                    </label>

                    <input
                        type="text"
                        id="identificador"
                        name="identificador"
                        autocomplete="username"
                        required
                    >

                    <button
                        class="botao"
                        type="submit"
                    >
                        Continuar
                    </button>

                </form>

            <?php endif; ?>


            <div class="rodape">

                <p>
                    Lembrou da senha?

                    <a
                        href="login.php"
                        style="color: green;"
                    >
                        Entrar no sistema
                    </a>
                </p>

            </div>

        </div>

    </section>

</main>

</body>

</html>

