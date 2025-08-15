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
  <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/themify-icons.css">
<link rel="stylesheet" href="../assets/css/metisMenu.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="../assets/css/slicknav.min.css">
<link rel="stylesheet" href="../assets/css/typography.css">
<link rel="stylesheet" href="../assets/css/default-css.css">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="../assets/css/responsive.css">
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css">


<script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
              <a href="/desafioDoacoes/dashboards/admin.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Home</a>
              <a href="/desafioDoacoes/includes/cadastro_organizador.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Cadastrar suportes</a>
              <a href="/desafioDoacoes/dashboards/relatorios.php" style="color: pink; text-decoration: none; display: block; margin-bottom: 10px;">Gerar relatórios</a>
              ';
            break;
          case 'organizador':
            echo '
              <a href="/desafioDoacoes/dashboards/organizador.php" style="color: white; text-decoration: none; display: block;text-align: center; margin-bottom: 10px;">Home</a>
              <a href="/desafioDoacoes/includes/validacao.php" style="color: white; text-decoration: none; display: block; text-align: center;margin-bottom: 10px;">Pendentes </a>
              
              ';
            break;
          case 'comum':
            echo '
              <a href="/desafioDoacoes/dashboards/usuario.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Home</a>              
              <a href="/desafioDoacoes/includes/formulario.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Fazer Doação</a>
              <a href="/desafioDoacoes/includes/listagem.php" style="color: white; text-decoration: none; display: block; margin-bottom: 10px;">Listagem</a>

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