<?php
declare(strict_types=1);

/** Raiz pública, inclusive quando a loja está em uma subpasta do servidor. */
function hqRaizUrl(): string
{
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/Projeto/loja.php'));
    if (preg_match('#^(.*?)/(?:Projeto|compra|Mangás|mangás|Mangas|mangas|marvel|Marvel|DC|dc)(?:/|$)#u', rawurldecode($script), $m)) {
        return rtrim($m[1], '/');
    }
    return rtrim(dirname($script), '/.');
}

/** Recebe caminhos relativos a Projeto; ../ aponta para a raiz do site. */
function hqUrl(string $caminho = ''): string
{
    if (preg_match('#^(?:https?:)?//#i', $caminho)) {
        return $caminho;
    }
    $partes = explode('?', $caminho, 2);
    $path = ltrim($partes[0], '/');
    $params = [];
    if (isset($partes[1])) {
        parse_str($partes[1], $params);
    }
    if (str_starts_with($path, '../')) {
        while (str_starts_with($path, '../')) {
            $path = substr($path, 3);
        }
    } else {
        $path = 'Projeto/' . $path;
    }
    $path = preg_replace('#^(?:mangás|mangas|Mangas)/#u', 'Mangás/', $path);
    $path = preg_replace('#^Imagens/#', 'imagens/', $path);
    static $rotas, $produtos;
    $rotas ??= require __DIR__ . '/rotas_legadas.php';
    $produtos ??= require __DIR__ . '/rotas_produtos.php';
    if (isset($produtos[$path])) {
        unset($params['id']);
        $params['codigo'] = $produtos[$path];
        $path = 'Projeto/produto.php';
    } else {
        $path = $rotas[$path] ?? $path;
    }
    $encoded = implode('/', array_map('rawurlencode', explode('/', trim(rawurldecode(hqRaizUrl() . '/' . $path), '/'))));
    return '/' . $encoded . ($params ? '?' . http_build_query($params) : '');
}

/** 307 preserva o corpo de formulários antigos; GET/HEAD usam 302. */
function hqRedirecionarCompatibilidade(string $destino, array $fixos = []): void
{
    $params = $_GET;
    if (isset($fixos['codigo'])) {
        unset($params['id']);
    }
    $params = array_replace($params, $fixos);
    $destino .= $params ? '?' . http_build_query($params) : '';
    $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    header('Location: ' . hqUrl($destino), true, in_array($metodo, ['GET', 'HEAD'], true) ? 302 : 307);
    exit;
}
