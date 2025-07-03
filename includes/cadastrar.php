<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
use \App\Entity\doacao;

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "1234", "validacao");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['item'], $_POST['data'], $_POST['quant'], $_POST['local'], $_POST['obs'])) {
    $doacao = new Doacao();

    // Processamento do arquivo
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
    $doacao->quant = $_POST['quant'] ?? '';
    $doacao->local = $_POST['local'] ?? '';
    $doacao->obs = $_POST['obs'] ?? '';
    
    try {
        $doacao->cadastrar();
        $_SESSION['mensagem'] = "Doação cadastrada com sucesso!";
        header("Location: perfil_usuario.php"); // Redireciona após cadastro
        exit;
    } catch (Exception $e) {
        $_SESSION['erro'] = "Erro ao cadastrar doação: " . $e->getMessage();
        header("Location: formulario_doacao.php"); // Volta ao formulário em caso de erro
        exit;
    }
} else {
    $_SESSION['erro'] = "Preencha todos os campos obrigatórios";
    header("Location: formulario_doacao.php");
    exit;
}