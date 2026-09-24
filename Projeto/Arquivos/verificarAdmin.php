<?php
require_once __DIR__ . '/verificarLogin.php';
if(!ehAdmin()){ flash('erro','Acesso restrito ao administrador.'); header('Location: '.url('loja.php')); exit; }
