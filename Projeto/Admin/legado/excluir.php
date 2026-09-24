<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../../Arquivos/conexao_conta.php';
require_once __DIR__ . '/../../Arquivos/verificarAdmin_legado.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../../conta/login.php");
    exit;
}
// Obtém o ID do produto
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: estoque.php");
    exit;
}
try {
    // O estoque é removido automaticamente pela chave estrangeira.
    $sql = "DELETE FROM produtos WHERE id = :id";

    $stmt = $strcon->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

} catch (PDOException $e) {
    error_log($e->getMessage());
}

header("Location: estoque.php");
exit;
?>
