<?php


require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\Usuario;

$conn = new mysqli("localhost", "root", "1234", "validacao");


if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['curso'], $_POST['tipo_usuario'])) {

  $usuario = new Usuario();
  $usuario->nome         = $_POST['nome'] ?? '';
  $usuario->email        = $_POST['email'] ?? '';
  $usuario->senha        = $_POST['senha'] ?? '';
  $usuario->curso        = $_POST['curso'] ?? '';
  $usuario->tipo_usuario = $_POST['tipo_usuario'] ?? '';
  $usuario->cadastrar();
}



