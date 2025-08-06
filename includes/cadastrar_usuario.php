<?php


require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\Usuario;
include('../includes/cabecalho.php');

$conn = new mysqli("localhost", "root", "1234", "validacao");


if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['curso'])) {

  $usuario = new Usuario();
  $usuario->nome         = $_POST['nome'] ?? '';
  $usuario->email        = $_POST['email'] ?? '';
  $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
  $usuario->senha = $senhaHash;
  $usuario->curso        = $_POST['curso'] ?? '';


  $usuario->cadastrar();


  
}



