<?php
declare(strict_types=1);
function e(?string $v): string { return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8'); }
function moeda(float $v): string { return 'R$ '.number_format($v,2,',','.'); }
require_once __DIR__ . '/caminhos.php';
function url(string $caminho = ''): string { return hqUrl($caminho); }
function usuarioLogado(): bool { return isset($_SESSION['valid']) && $_SESSION['valid']===true; }
function ehAdmin(): bool { return usuarioLogado() && ($_SESSION['tipo']??'')==='admin'; }
function carrinhoQuantidade(): int { return array_sum(array_map('intval', $_SESSION['carrinho']??[])); }
function flash(string $tipo,string $texto): void { $_SESSION['flash']=['tipo'=>$tipo,'texto'=>$texto]; }
function mostrarFlash(): void { if(empty($_SESSION['flash'])) return; $f=$_SESSION['flash']; unset($_SESSION['flash']); echo '<div class="alerta alerta-'.e($f['tipo']).'">'.e($f['texto']).'</div>'; }
