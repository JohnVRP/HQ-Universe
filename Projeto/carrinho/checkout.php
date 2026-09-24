<?php
require_once __DIR__ . '/../Arquivos/verificarLogin.php';
require_once __DIR__ . '/../Arquivos/conexao.php';
require_once __DIR__ . '/../Arquivos/funcoes.php';
$cart=$_SESSION['carrinho']??[]; if(!$cart){flash('erro','Carrinho vazio.');header('Location: carrinho.php');exit;}
$ids=array_keys($cart);$marks=implode(',',array_fill(0,count($ids),'?'));
$st=$pdo->prepare("SELECT p.*,e.quantidade estoque FROM produtos p JOIN estoque e ON e.produto_id=p.id WHERE p.id IN ($marks)");$st->execute($ids);
$produtos=[];$subtotal=0;foreach($st as $p){$q=(int)$cart[$p['id']];if($q<1||$q>(int)$p['estoque']){flash('erro','Revise as quantidades.');header('Location: carrinho.php');exit;}$p['q']=$q;$subtotal+=$q*(float)$p['preco'];$produtos[]=$p;}
$formas=$pdo->query('SELECT * FROM formas_pagamento WHERE ativo=1')->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $cep=preg_replace('/\D/','',$_POST['entrega_cep']??'');$endereco=trim($_POST['entrega_endereco']??'');$frete=(float)($_POST['entrega_frete']??0);$prazo=trim($_POST['entrega_prazo']??'');
 if(strlen($cep)!==8||$endereco===''||$frete<=0){flash('erro','Calcule e confirme o endereço de entrega.');header('Location: checkout.php');exit;}
 $total=$subtotal+$frete;
 $forma=(int)($_POST['forma']??0);
 $formaValida=$pdo->prepare('SELECT COUNT(*) FROM formas_pagamento WHERE id=? AND ativo=1');
 $formaValida->execute([$forma]);
 if((int)$formaValida->fetchColumn()!==1){flash('erro','Selecione uma forma de pagamento válida.');header('Location: checkout.php');exit;}
 try{$pdo->beginTransaction();
 // Compatibilidade com bancos já importados antes das colunas de entrega.
 $colunasPedido = [];
 foreach ($pdo->query("SHOW COLUMNS FROM pedidos") as $colunaPedido) {
   $colunasPedido[(string)$colunaPedido['Field']] = true;
 }

 $observacaoOriginal = trim((string)($_POST['observacao'] ?? ''));
 $detalhesEntrega = "Entrega: CEP {$cep}; {$endereco}; frete " . moeda($frete) . "; prazo {$prazo}.";
 $observacaoFinal = trim($observacaoOriginal . ($observacaoOriginal !== '' ? " | " : "") . $detalhesEntrega);

 $dadosPedido = [
   'usuario_id' => (int)$_SESSION['id'],
   'forma_pagamento_id' => $forma,
   'status' => 'pendente',
   'valor_total' => $total,
   'observacao' => $observacaoFinal
 ];

 $dadosOpcionais = [
   'cep_entrega' => $cep,
   'endereco_entrega' => $endereco,
   'valor_frete' => $frete,
   'prazo_entrega' => $prazo
 ];

 foreach ($dadosOpcionais as $coluna => $valor) {
   if (isset($colunasPedido[$coluna])) {
     $dadosPedido[$coluna] = $valor;
   }
 }

 $colunasInsert = array_keys($dadosPedido);
 $marcadoresInsert = implode(',', array_fill(0, count($colunasInsert), '?'));
 $sqlPedido = 'INSERT INTO pedidos (' . implode(',', $colunasInsert) . ') VALUES (' . $marcadoresInsert . ')';
 $insPedido = $pdo->prepare($sqlPedido);
 $insPedido->execute(array_values($dadosPedido));
 $pedido=(int)$pdo->lastInsertId();
 // A baixa é atômica: só ocorre se ainda houver a quantidade necessária.
 $ins=$pdo->prepare('INSERT INTO itens_pedido(pedido_id,produto_id,quantidade,preco_unitario) VALUES(?,?,?,?)');$upd=$pdo->prepare('UPDATE estoque SET quantidade=quantidade-? WHERE produto_id=? AND quantidade>=?');
 foreach($produtos as $p){$ins->execute([$pedido,$p['id'],$p['q'],$p['preco']]);$upd->execute([$p['q'],$p['id'],$p['q']]);if($upd->rowCount()!==1)throw new RuntimeException('Estoque insuficiente.');}
 $pdo->commit();unset($_SESSION['carrinho']);flash('sucesso','Pedido #'.$pedido.' criado. Pagamento e frete simulados.');header('Location: ../conta/meusPedidos.php');exit;
 }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();flash('erro','Não foi possível finalizar: '.$e->getMessage());header('Location: carrinho.php');exit;}
}
?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Checkout | HQ Universe</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../CSS/checkout.css?v=60">

  <link rel="stylesheet" href="../../CSS/estilo_jvrp.css?v=60">
  <link rel="stylesheet" href="../../CSS/funcionalidades.css?v=60">
</head><body class="pagina-checkout">
  <?php require_once __DIR__ . '/../Arquivos/cabecalho.php'; ?>
  <?php mostrarFlash();?><main class="conteudo limite"><h1>Finalizar compra</h1><form method="post" class="checkout-layout" onsubmit="return document.getElementById('entrega_cep').value.length===8"><div class="formulario"><h2>Endereço de entrega</h2><div class="campo"><label>CEP</label><div style="display:flex;gap:8px"><input id="cep-checkout" type="text" maxlength="9" placeholder="00000-000" required><button class="botao-secundario" type="button" onclick="calcularFreteHQ('cep-checkout','frete-checkout','entrega')">Calcular</button></div><div id="frete-checkout" class="hq-frete-resultado"></div></div><input type="hidden" name="entrega_cep" id="entrega_cep"><input type="hidden" name="entrega_endereco" id="entrega_endereco"><input type="hidden" name="entrega_frete" id="entrega_frete"><input type="hidden" name="entrega_prazo" id="entrega_prazo"><h2>Pagamento de teste</h2><div class="campo"><label>Forma de pagamento</label><select name="forma" required><?php foreach($formas as $f):?><option value="<?=$f['id']?>"><?=e($f['nome'])?></option><?php endforeach;?></select></div><div class="campo"><label>Observação</label><textarea name="observacao"></textarea></div><p><small>A consulta identifica o endereço pelo CEP; o valor do frete é uma simulação acadêmica com origem em São Paulo/SP.</small></p></div><aside class="resumo"><h2>Resumo</h2><?php foreach($produtos as $p):?><p><?=e($p['nome'])?> × <?=$p['q']?> <b><?=moeda($p['q']*$p['preco'])?></b></p><?php endforeach;?><hr><p>Subtotal <b><?=moeda($subtotal)?></b></p><p>O frete será somado ao confirmar.</p><button class="botao">Confirmar pedido</button></aside></form></main><?php require_once __DIR__ . '/../Arquivos/rodape.php';?><script src="../../JS/frete.js"></script></body></html>