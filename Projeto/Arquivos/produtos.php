<?php
declare(strict_types=1);
require_once __DIR__ . '/funcoes.php';

/** Catálogo anterior: compatibilidade e campos editoriais ausentes. */
function hqCatalogo(): array
{
    static $catalogo;
    if ($catalogo === null) {
        $catalogo = require __DIR__ . '/catalogo_estatico.php';
        foreach (require __DIR__ . '/complementos_produtos.php' as $codigo => $dados) {
            $catalogo[$codigo] = array_replace($catalogo[$codigo] ?? [], $dados);
            $catalogo[$codigo]['codigo_catalogo'] = (int) $codigo;
        }
    }
    return $catalogo;
}
function hqNormalizarProduto(string $nome): string
{
    $nome = mb_strtolower($nome, 'UTF-8');
    $nome = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nome) ?: $nome;
    $nome = preg_replace('/\bvol(?:ume)?\.?\s*0*(\d+)/', 'vol $1', $nome);
    return trim(preg_replace('/[^a-z0-9]+/', ' ', $nome));
}
function hqMesmoProduto(array $cadastro, array $referencia): bool
{
    $nome = hqNormalizarProduto((string) ($cadastro['nome'] ?? ''));
    foreach (['nome', 'nome_original'] as $campo) {
        if ($nome !== '' && $nome === hqNormalizarProduto((string) ($referencia[$campo] ?? ''))) {
            return true;
        }
    }
    $imagem = mb_strtolower(basename((string) ($cadastro['imagem'] ?? '')));
    return $imagem !== '' && in_array($imagem, [
        mb_strtolower(basename((string) ($referencia['imagem'] ?? ''))),
        mb_strtolower(basename((string) ($referencia['imagem_original'] ?? ''))),
    ], true);
}
/** Uma consulta por requisição; não altera IDs, produtos nem estoque. */
function hqProdutosDoBanco(PDO $pdo): array
{
    static $cache = [];
    $chave = spl_object_id($pdo);
    if (!isset($cache[$chave])) {
        $cache[$chave] = [];
        $sql = 'SELECT p.*, c.nome AS categoria, COALESCE(e.quantidade, 0) AS estoque
                FROM produtos p LEFT JOIN categorias c ON c.id = p.categoria_id
                LEFT JOIN estoque e ON e.produto_id = p.id';
        foreach ($pdo->query($sql) as $produto) {
            $cache[$chave][(int) $produto['id']] = $produto;
        }
    }
    return $cache[$chave];
}
/** Vínculos conferidos permanecem estáveis mesmo após editar nome e imagem. */
function hqCadastroPorCodigo(PDO $pdo, int $codigo): ?array
{
    $referencia = hqCatalogo()[$codigo] ?? null;
    if (!$referencia) return null;
    $banco = hqProdutosDoBanco($pdo);
    if (isset($referencia['id_banco'])) {
        return $banco[(int) $referencia['id_banco']] ?? null;
    }
    // Referências ainda sem vínculo explícito exigem uma identidade inequívoca.
    if (isset($banco[$codigo]) && hqMesmoProduto($banco[$codigo], $referencia)) {
        return $banco[$codigo];
    }
    $encontrados = array_filter($banco, fn(array $p): bool => hqMesmoProduto($p, $referencia));
    return count($encontrados) === 1 ? array_values($encontrados)[0] : null;
}
function hqCompletarProduto(array $produto, ?array $referencia = null): array
{
    if ($referencia) {
        foreach (['autor', 'ano_publicacao', 'paginas', 'isbn', 'descricao', 'imagem', 'editora'] as $campo) {
            if (!isset($produto[$campo]) || trim((string) $produto[$campo]) === '') {
                $produto[$campo] = $referencia[$campo] ?? '';
            }
        }
        $produto['codigo_catalogo'] = $referencia['codigo_catalogo'];
        $produto['parcelas'] = $referencia['parcelas'] ?? 1;
    }
    $produto['estoque'] = max(0, (int) ($produto['estoque'] ?? 0));
    $produto['categoria'] = $produto['categoria'] ?? ([1 => 'Mangás', 2 => 'Marvel', 3 => 'DC Comics'][(int) ($produto['categoria_id'] ?? 0)] ?? 'Produto');
    return $produto;
}
function hqProdutoPorCodigo(PDO $pdo, int $codigo): ?array
{
    $referencia = hqCatalogo()[$codigo] ?? null;
    if (!$referencia) return null;
    $cadastro = hqCadastroPorCodigo($pdo, $codigo);
    if ($cadastro) {
        return (int) $cadastro['ativo'] === 1 ? hqCompletarProduto($cadastro, $referencia) : null;
    }
    // Registro ausente nunca recebe estoque fictício.
    return hqCompletarProduto(array_replace($referencia, ['id' => null, 'estoque' => 0]), $referencia);
}
function hqProdutoPorId(PDO $pdo, int $id): ?array
{
    $produto = hqProdutosDoBanco($pdo)[$id] ?? null;
    if (!$produto || (int) $produto['ativo'] !== 1) return null;
    foreach (hqCatalogo() as $codigo => $referencia) {
        if ((int) (hqCadastroPorCodigo($pdo, (int) $codigo)['id'] ?? 0) === $id) {
            return hqCompletarProduto($produto, $referencia);
        }
    }
    return hqCompletarProduto($produto);
}
function hqTodosProdutos(PDO $pdo): array
{
    $produtos = [];
    foreach (hqProdutosDoBanco($pdo) as $id => $produto) {
        if ((int) $produto['ativo'] === 1) $produtos['id:' . $id] = hqCompletarProduto($produto);
    }
    foreach (hqCatalogo() as $codigo => $_) {
        $produto = hqProdutoPorCodigo($pdo, (int) $codigo);
        if ($produto) {
            $chave = !empty($produto['id']) ? 'id:' . $produto['id'] : 'codigo:' . $codigo;
            $produtos[$chave] = $produto;
        }
    }
    return array_values($produtos);
}
function hqUrlProduto(array $produto): string
{
    return !empty($produto['id'])
        ? url('produto.php?id=' . (int) $produto['id'])
        : url('produto.php?codigo=' . (int) ($produto['codigo_catalogo'] ?? 0));
}
