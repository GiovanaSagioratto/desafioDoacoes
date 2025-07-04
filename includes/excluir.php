<?php
session_start();
require __DIR__.'/../vendor/autoload.php';

use App\Db\Database;

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

if (!isset($_GET['id'])) {
    header("Location: listagem.php");
    exit;
}

$idDoacao = (int)$_GET['id'];


$db = new Database('doacao');
$pdo = $db->getConnection();
$stmt = $pdo->prepare("SELECT * FROM doacao WHERE id = :id AND id_usuario = :usuario");
$stmt->bindParam(':id', $idDoacao);
$stmt->bindParam(':usuario', $id_usuario);
$stmt->execute();
$doacao = $stmt->fetch();

if (!$doacao) {
    echo "Doação não encontrada ou você não tem permissão.";
    exit;
}


$stmt = $pdo->prepare("DELETE FROM doacao WHERE id = :id");
$stmt->bindParam(':id', $idDoacao);
$stmt->execute();

// Redireciona de volta
header("Location: listagem.php");
exit;