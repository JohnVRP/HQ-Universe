<?php
if(session_status()!==PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/funcoes.php';
if(!usuarioLogado()){ flash('erro','Faça login para continuar.'); header('Location: '.url('login.php')); exit; }
