<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Doacao;

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID não informado']);
    exit;
}

$id = (int) $_GET['id'];
$doacao = Doacao::getDoacaoPorId($id);

if (!$doacao || $doacao->id_usuario != $_SESSION['id_usuario']) {
    echo json_encode(['status' => 'error', 'message' => 'Permissão negada']);
    exit;
}

echo json_encode([
    'status' => 'success',
    'doacao' => [
        'id' => $doacao->id,
        'item' => $doacao->item,
        'local' => $doacao->local,
        'obs' => $doacao->obs,
    ]
]);