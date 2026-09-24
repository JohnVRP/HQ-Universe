<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Escolha entre mangás, Marvel e DC Comics na HQ Universe">
    <title>Explorar Coleção | HQ Universe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Mantém os mesmos estilos já usados no seu site -->
    <link rel="stylesheet" href="../CSS/estilo_jvrp.css?v=60">
    <link rel="stylesheet" href="../CSS/funcionalidades.css?v=60">

    <!-- Estilos exclusivos desta página: ficam aqui para você adicionar somente este PHP -->
    <style>
        .colecao-pagina {
            background: #f5f5f5;
            padding: 70px 0 85px;
        }

        .colecao-container {
            width: min(1200px, 90%);
            margin: 0 auto;
        }

        .colecao-cabecalho {
            text-align: center;
            margin-bottom: 42px;
        }

        .colecao-cabecalho h1 {
            margin: 0 0 10px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(38px, 4vw, 58px);
            letter-spacing: 1px;
            color: #111;
        }

        .colecao-cabecalho p {
            margin: 0 auto;
            max-width: 650px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: #555;
        }

        .colecao-linha {
            width: 70px;
            height: 5px;
            background: #ffd000;
            border-radius: 999px;
            margin: 18px auto 0;
        }

        .colecao-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 30px;
            align-items: stretch;
        }

        .colecao-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.10);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .colecao-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.16);
        }

        .colecao-imagem {
            width: 100%;
            height: 390px;
            object-fit: cover;
            display: block;
            background: #151515;
        }

        .colecao-conteudo {
            padding: 27px 25px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .colecao-tag {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 6px 16px;
            margin-bottom: 14px;
            border-radius: 5px;
            background: #ffd000;
            color: #111;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .colecao-card h2 {
            margin: 0 0 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 25px;
            font-weight: 600;
            color: #111;
        }

        .colecao-card p {
            margin: 0 0 24px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            line-height: 1.7;
            color: #555;
            max-width: 310px;
        }

        .colecao-botao {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 145px;
            min-height: 48px;
            margin-top: auto;
            padding: 11px 25px;
            border-radius: 5px;
            background: #d92323;
            color: #fff;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            transition: background .2s ease, transform .2s ease;
        }

        .colecao-botao:hover {
            background: #b91818;
            color: #fff;
            transform: translateY(-1px);
        }

        @media (max-width: 900px) {
            .colecao-grid {
                grid-template-columns: 1fr;
                max-width: 620px;
                margin: 0 auto;
            }

            .colecao-imagem {
                height: 340px;
            }
        }

        @media (max-width: 576px) {
            .colecao-pagina {
                padding: 45px 0 60px;
            }

            .colecao-container {
                width: 92%;
            }

            .colecao-cabecalho {
                margin-bottom: 30px;
            }

            .colecao-imagem {
                height: 280px;
            }

            .colecao-conteudo {
                padding: 22px 18px 25px;
            }
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/Arquivos/cabecalho.php'; ?>

    <main class="colecao-pagina">
        <div class="colecao-container">
            <header class="colecao-cabecalho">
                <h1>Escolha seu universo</h1>
                <p>Explore nossa coleção e escolha entre mangás, histórias da Marvel ou o universo da DC Comics.</p>
                <div class="colecao-linha" aria-hidden="true"></div>
            </header>

            <section class="colecao-grid" aria-label="Categorias da coleção">

                <!-- MANGÁS -->
                <article class="colecao-card">
                    <!-- Troque apenas o src abaixo pela imagem que você quiser -->
                    <img class="colecao-imagem" src="../imagens/manga_colecao.jpg" alt="Coleção de Mangás">
                    <div class="colecao-conteudo">
                        <span class="colecao-tag">Mangás</span>
                        <h2>Mangás</h2>
                        <p>Descubra grandes histórias japonesas, dos clássicos aos títulos mais procurados da
                            atualidade.</p>
                        <a class="colecao-botao" href="Mangás.php">Acessar</a>
                    </div>
                </article>

                <!-- MARVEL -->
                <article class="colecao-card">
                    <!-- Troque apenas o src abaixo pela imagem que você quiser -->
                    <img class="colecao-imagem" src="../imagens/marvel_3.jpg" alt="Coleção Marvel">
                    <div class="colecao-conteudo">
                        <span class="colecao-tag">Marvel</span>
                        <h2>Marvel</h2>
                        <p>Encontre aventuras, heróis e grandes sagas do universo Marvel reunidas em um só lugar.</p>
                        <a class="colecao-botao" href="../marvel/marvel.php">Acessar</a>
                    </div>
                </article>

                <!-- DC COMICS -->
                <article class="colecao-card">
                    <!-- Troque apenas o src abaixo pela imagem que você quiser -->
                    <img class="colecao-imagem" src="../imagens/DC_logo.png" alt="Coleção DC Comics">
                    <div class="colecao-conteudo">
                        <span class="colecao-tag">DC Comics</span>
                        <h2>DC Comics</h2>
                        <p>Explore histórias marcantes, grandes personagens e sagas inesquecíveis do universo DC.</p>
                        <a class="colecao-botao" href="../DC/DC.php">Acessar</a>
                    </div>
                </article>

            </section>
        </div>
    </main>

    <?php require_once __DIR__ . '/Arquivos/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>