<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'mensagem' => 'Digite um e-mail válido.']);
    exit;
}
$arquivo = __DIR__ . '/Banco/newsletter.csv';
@mkdir(dirname($arquivo), 0775, true);
$existentes = file_exists($arquivo) ? file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
foreach ($existentes as $linha) {
    if (strcasecmp(trim(explode(';', $linha)[0]), $email) === 0) {
        echo json_encode(['ok' => true, 'mensagem' => 'Este e-mail já está cadastrado.']);
        exit;
    }
}
$ok = file_put_contents($arquivo, $email . ';' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND | LOCK_EX);
if ($ok === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensagem' => 'Não foi possível salvar o cadastro.']);
    exit;
}
echo json_encode(['ok' => true, 'mensagem' => 'Cadastro realizado! Em breve você receberá novidades.']);
