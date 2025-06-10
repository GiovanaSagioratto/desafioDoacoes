<?php 

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Usuario;

if (isset($_POST['id_usuario'],$_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['curso'],$_POST['tipo_usuario'])) {
    die ('cadastrar');

  $usuario = new Usuario();
  $usuario->id_usuario           = $_POST['id_usuario'] ?? '';
  $usuario->nome         = $_POST['nome'] ?? '';
  $usuario->email        = $_POST['email'] ?? '';
  $usuario->senha        = $_POST['senha'] ?? '';
  $usuario->curso        = $_POST['curso'] ?? '';
  $usuario->tipo_usuario = $_POST['tipo_usuario'] ?? '';
  
  $usuario->cadastrar();

  }

  



?>