<?php
   
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/cabecalho.php');
include('../includes/exibir_horas.php');
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Usuario;


$usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
$_SESSION['tipo_usuario'] = $usuario->tipo_usuario;
?>
   
  
