<?php


require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\Usuario;


$conn = new mysqli("localhost", "root", "1234", "validacao");


if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $usuario = new Usuario();
  $usuario->tipo_usuario = $_POST['tipo_usuario'] ?? 'comum';
  $usuario->nome         = $_POST['nome'] ?? '';
  $usuario->email        = $_POST['email'] ?? '';
  $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
  $usuario->senha = $senhaHash;
  $usuario->curso        = $_POST['curso'] ?? '';


  $usuario->cadastrarComum();

    header('Location: ../login.php');
    exit;


  
}



