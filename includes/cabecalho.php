<?php
use App\Entity\Usuario;
require __DIR__ . '/../vendor/autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nomeUsuario = 'Usuário';
$fotoPerfil = 'https://via.placeholder.com/40';

if (isset($_SESSION['id_usuario'])) {
    $usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
    if ($usuario) {
        $nomeUsuario = $usuario->nome;
        if (!empty($usuario->foto_perfil)) {
            $fotoPerfil = $usuario->foto_perfil;
        }
    }
}
if (isset($_SESSION['id_usuario'])) {
  $usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
  if ($usuario && isset($usuario->nome)) {
    $nomeUsuario = $usuario->nome;
  }
}
?>

<img src="<?= $fotoPerfil ?>" style="width:40px;height:40px;border-radius:50%;">
<span style="color:white;margin-left:10px;"><?= htmlspecialchars($nomeUsuario) ?></span>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Sistema</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }
  </style>
</head>

<body>

  <div class="page-container" style="display: flex; height: 100vh;">
    <!-- Sidebar esquerda -->
    <div class="sidebar-menu" style="width: 250px; background: #303641;">
      <div class="sidebar-header" style="padding: 19px 32px 20px; border-bottom: 1px solid #343e50;">
        <img src="../assets/images/author/logopaCControl.png" style="width: 200px; height: 190px;" />
      </div>
      <div class="menu-inner">
        <!-- nav aqui se quiser -->
      </div>
    </div>

    <!-- Área principal começa aqui -->
    <div class="main-area" style="flex: 1; display: flex; flex-direction: column;">
      <!-- Barra superior -->
      <div style="display:flex;justify-content:flex-end;align-items:center;background:#2c3e50;padding:10px 20px;">
        <div style="position:relative;" onmouseenter="this.querySelector('.dropdown').style.display='block'"
          onmouseleave="this.querySelector('.dropdown').style.display='none'">

          <div style="cursor:pointer;display:flex;align-items:center;">
            <img src="<?= $usuario->foto_perfil ?? 'https://via.placeholder.com/40' ?>" style="width:40px;height:40px;border-radius:50%;">
            <span style="color:white;margin-left:10px;"><?= htmlspecialchars($nomeUsuario) ?></span>
          </div>

          <div class="dropdown"
            style="display:none;position:fixed;top:60px;right:20px;background:#fff;min-width:160px;border:1px solid #ccc;border-radius:4px;box-shadow:0 4px 6px rgba(0,0,0,0.1);z-index:9999;">
            <a href="editar_usuario.php" style="display:block;padding:10px 15px;text-decoration:none;color:#000;">Editar Perfil</a>
            <a href="../login.php" style="display:block;padding:10px 15px;text-decoration:none;color:#000;">Sair</a>
          </div>

        </div>
      </div>