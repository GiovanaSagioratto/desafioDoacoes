<?php
require __DIR__.'/../vendor/autoload.php';

use App\Entity\Doacao;

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $doacao = Doacao::getDoacaoPorId((int)$_POST['id']);

    if (!$doacao || $doacao->id_usuario != $_SESSION['id_usuario']) {
        echo "Permissão negada.";
        exit;
    }

    $doacao->item = $_POST['item'];
    $doacao->local = $_POST['local'];
    $doacao->obs = $_POST['obs'];

    $doacao->atualizar();

    header('Location: listagem.php');
    exit;
}

echo "Erro ao editar.";