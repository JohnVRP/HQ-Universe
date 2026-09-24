<?php
require_once __DIR__ . '/../Arquivos/foto_perfil.php'; require_once __DIR__ . '/../Arquivos/verificarAdmin.php'; require_once __DIR__ . '/../Arquivos/conexao.php'; 
$fotoAdmin = null;

if (!empty($_SESSION['id']) && isset($pdo)) {
    try {
        $stFotoAdmin = $pdo->prepare('SELECT foto FROM usuarios WHERE id = ?');
        $stFotoAdmin->execute([(int) $_SESSION['id']]);
        $fotoAdmin = $stFotoAdmin->fetchColumn() ?: null;
    } catch (Throwable $erroFotoAdmin) {
        $fotoAdmin = null;
    }
}
?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin | HQ Universe</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Bangers&family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../CSS/admin.css?v=60">

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head><body class="pagina-admin">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  <?php mostrarFlash();?><main class="conteudo limite"><nav class="admin-menu"><a href="<?=url('Admin/index.php')?>">Dashboard</a><a href="<?=url('Admin/produtos.php')?>">Produtos</a><a href="<?=url('Admin/categorias.php')?>">Categorias</a><a href="<?=url('Admin/estoque.php')?>">Estoque</a><a href="<?=url('Admin/usuarios.php')?>">Usuários</a><a href="<?=url('Admin/pedidos.php')?>">Pedidos</a><a href="<?=url('loja.php')?>">Ver loja</a></nav><?php $dados=['Produtos'=>$pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn(),'Clientes'=>$pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo='cliente'")->fetchColumn(),'Pedidos'=>$pdo->query('SELECT COUNT(*) FROM pedidos')->fetchColumn(),'Faturamento'=>$pdo->query("SELECT COALESCE(SUM(valor_total),0) FROM pedidos WHERE status<>'cancelado'")->fetchColumn()];?><h1>Painel administrativo</h1>
<img class="admin-avatar-img" src="<?= e(fotoPerfilUrl($fotoAdmin)) ?>" alt="Foto do administrador"><div class="metricas"><?php foreach($dados as $k=>$v):?><div class="metrica"><span><?=e($k)?></span><b><?=$k==='Faturamento'?moeda((float)$v):$v?></b></div><?php endforeach;?></div>
        <a class="btn btn-outline-primary w-100 mt-2" href="../conta/meuPerfil.php">👤 Alterar meu perfil</a>
</main><?php require_once __DIR__ . '/../Arquivos/rodape.php';?>  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>