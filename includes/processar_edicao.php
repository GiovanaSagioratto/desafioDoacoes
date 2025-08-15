<?php
require __DIR__.'/../vendor/autoload.php';


use App\Entity\Doacao;

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuário não logado.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $doacao = Doacao::getDoacaoPorId((int)$_POST['id']);

    if (!$doacao || $doacao->id_usuario != $_SESSION['id_usuario']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Permissão negada.'
        ]);
        exit;
    }

    $doacao->item = $_POST['item'];
    $doacao->local = $_POST['local'];
    $doacao->obs = $_POST['obs'];

    if ($doacao->atualizar()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Doação atualizada com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao atualizar a doação.'
        ]);
    }
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Requisição inválida.'
]);
