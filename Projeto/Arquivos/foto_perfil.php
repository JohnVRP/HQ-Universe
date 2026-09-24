<?php

declare(strict_types=1);
require_once __DIR__ . '/funcoes.php';


/**
 * Garante que a coluna foto exista em instalações antigas do banco.
 */
function garantirColunaFotoPerfil(PDO $pdo): void
{
    $consulta = $pdo->query("SHOW COLUMNS FROM usuarios LIKE 'foto'");

    if (!$consulta->fetch()) {
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN foto VARCHAR(255) NULL AFTER telefone");
    }
}

/**
 * Retorna o caminho público da foto do usuário.
 */
function fotoPerfilUrl(?string $foto): string
{
    $foto = trim((string) $foto);

    $caminho = $foto === ''
        ? 'uploads/perfis/avatar-padrao.svg'
        : ltrim($foto, '/');

    if (function_exists('hurl')) {
        return hurl($caminho);
    }

    return url($caminho);
}

/**
 * Processa e salva uma nova foto de perfil.
 *
 * @return string|null Caminho relativo salvo no banco ou null quando nenhum arquivo foi enviado.
 */
function salvarFotoPerfil(array $arquivo, int $usuarioId, ?string $fotoAtual = null): ?string
{
    if (($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($arquivo['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Não foi possível enviar a imagem.');
    }

    $tamanhoMaximo = 2 * 1024 * 1024;

    if ((int) ($arquivo['size'] ?? 0) > $tamanhoMaximo) {
        throw new RuntimeException('A imagem deve ter no máximo 2 MB.');
    }

    $temporario = (string) ($arquivo['tmp_name'] ?? '');

    if ($temporario === '' || !is_uploaded_file($temporario)) {
        throw new RuntimeException('Arquivo de imagem inválido.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = (string) $finfo->file($temporario);

    $extensoes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($extensoes[$mime])) {
        throw new RuntimeException('Use uma imagem JPG, PNG ou WEBP.');
    }

    $destinoDiretorio = dirname(__DIR__) . '/uploads/perfis';

    if (!is_dir($destinoDiretorio) && !mkdir($destinoDiretorio, 0755, true) && !is_dir($destinoDiretorio)) {
        throw new RuntimeException('Não foi possível preparar a pasta de fotos.');
    }

    $extensao = $extensoes[$mime];
    $nomeArquivo = 'perfil_' . $usuarioId . '_' . bin2hex(random_bytes(6)) . '.' . $extensao;
    $destino = $destinoDiretorio . '/' . $nomeArquivo;

    if (!move_uploaded_file($temporario, $destino)) {
        throw new RuntimeException('Não foi possível salvar a imagem.');
    }

    if ($fotoAtual) {
        $fotoAtual = ltrim($fotoAtual, '/');

        if (str_starts_with($fotoAtual, 'uploads/perfis/')) {
            $arquivoAtual = dirname(__DIR__) . '/' . $fotoAtual;

            if (is_file($arquivoAtual)) {
                @unlink($arquivoAtual);
            }
        }
    }

    return 'uploads/perfis/' . $nomeArquivo;
}
