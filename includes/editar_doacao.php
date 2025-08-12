<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Doacao;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $item = trim($_POST['item']);
    $local = trim($_POST['local']);
    $obs = trim($_POST['obs']);

    $doacao = Doacao::getDoacaoPorId($id);

    if (!$doacao || $doacao->id_usuario != $_SESSION['id_usuario']) {
        echo json_encode(['status' => 'error', 'message' => 'Permissão negada']);
        exit;
    }

    $doacao->item = $item;
    $doacao->local = $local;
    $doacao->obs = $obs;
    $doacao->atualizar();

    echo json_encode(['status' => 'success', 'message' => 'Doação atualizada com sucesso']);
    exit;
}
echo json_encode(['status' => 'error', 'message' => 'Método inválido']);
exit;