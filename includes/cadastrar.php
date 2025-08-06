<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
use \App\Entity\doacao;

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

include('../includes/cabecalho.php');

$conn = new mysqli("localhost", "root", "1234", "validacao");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['item'], $_POST['data'], $_POST['local'], $_POST['obs'],$_POST['categoria'])) {
    $doacao = new Doacao();

    
    if (!empty($_FILES['arquivo']['name'])) {
        $nomeArquivo = basename($_FILES['arquivo']['name']);
        $caminho = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho)) {
            $doacao->arquivo = $caminho;
        } else {
            $doacao->arquivo = ''; 
        }
    } else {
        $doacao->arquivo = '';
    }


    $doacao->id_usuario = $_SESSION['id_usuario'];
    $doacao->item = $_POST['item'] ?? '';
    $doacao->data = $_POST['data'] ?? '';
    $doacao->categoria = $_POST['categoria'] ?? '';
    $doacao->local = $_POST['local'] ?? '';
    $doacao->obs = $_POST['obs'] ?? '';
    $doacao->campanha = $_POST['campanha'] ?? '';
    
    
    
    try {
        $doacao->cadastrar();
        $_SESSION['mensagem'] = "Doação cadastrada com sucesso!";
       header("Location: formulario.php"); 
        exit;
    } catch (Exception $e) {
        $_SESSION['erro'] = "Erro ao cadastrar doação: " . $e->getMessage();
        header("Location: formulario.php"); 
        exit;
    }
} else {
    $_SESSION['erro'] = "Preencha todos os campos obrigatórios";
    header("Location: formulario.php");
    exit;
}
