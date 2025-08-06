<?php
use App\Entity\Usuario;
require __DIR__ . '/../vendor/autoload.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$nomeUsuario = 'Usuário';
if (isset($_SESSION['id_usuario'])) {
  $usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
  if ($usuario && isset($usuario->nome)) {
    $nomeUsuario = $usuario->nome;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Sistema</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: sans-serif;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background: #303641;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
    }

    .sidebar-header {
      padding: 20px;
      border-bottom: 1px solid #343e50;
      text-align: center;
    }

    .sidebar-header img {
      width: 180px;
      height: auto;
    }

    .menu-inner {
      padding: 20px;
      color: white;
      /* Você pode adicionar aqui o menu lateral depois */
    }

    .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
    }

    .topbar {
      width: 100%;
      height: 60px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      background: white;
      padding: 10px 20px;
      border-bottom: 1px solid #ccc;
    }

    .user-menu {
      position: relative;
    }

    .user-name {
      cursor: pointer;
      display: flex;
      align-items: center;
      background: #2c3e50;
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
    }

    .user-name span {
      margin-right: 8px;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background: #fff;
      min-width: 120px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 9999;
    }

    .dropdown a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #000;
    }

    .dropdown a:hover {
      background: #f5f5f5;
    }

    .user-menu:hover .dropdown {
      display: block;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="../assets/images/author/logopaCControl.png" alt="Logo">
    </div>
    <div class="menu-inner">
      <?php
      if (isset($usuario->tipo_usuario)) {
        switch ($usuario->tipo_usuario) {
          case 'admin':
            echo '
              <a href="/desafioDoacoes/includes/validacao.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Pendentes</a>
              <a href="/desafioDoacoes/includes/cadastro_organizador.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Cadastrar suportes</a>
              <a href="/desafioDoacoes/dashboards/relatorios.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Gerar relatórios</a>
              ';
            break;

          case 'organizador':
            echo '
              <a href="/desafioDoacoes/includes/visualizar_doacoes.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Visualizar Doações</a>
              <a href="/desafioDoacoes/includes/gerenciar_usuarios.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Gerenciar Usuários</a>
              ';
            break;

          case 'usuario':
            echo '
              <a href="/desafioDoacoes/includes/minhas_doacoes.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Minhas Doações</a>
              <a href="/desafioDoacoes/includes/doar.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Fazer Doação</a>
              ';
            break;
        }
      } else {
        echo '<p style="color: white;">Perfil não identificado</p>';
      }
      ?>
    </div>
  </div>

  <!-- Conteúdo principal -->
  <div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
      <div class="user-menu">
        <div class="user-name">
          <span><?= htmlspecialchars($nomeUsuario) ?></span>
          <span>▼</span>
        </div>
        <div class="dropdown">
          <a href="../login.php">Sair</a>
        </div>
      </div>
    </div>