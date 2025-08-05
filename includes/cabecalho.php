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

  <meta charset="UTF-8">
  <title>Sistema</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    .topbar {
      width: 100%;
      height: 10%;
      display: flex;
      justify-content: right;
      align-items: center;
      background: white;
      padding: 10px 20px;
    }

    .user-menu {
      position: relative;
    }

    .user-name {
      cursor: pointer;
      display: flex;
      align-items: center;
      background:  #2c3e50;
      color: #333;
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

        <div class="sidebar-menu" style="width: 250px; background: #303641;">
      <div class="sidebar-header" style="padding: 19px 32px 20px; border-bottom: 1px solid #343e50;">
        <img src="../assets/images/author/logopaCControl.png" style="width: 200px; height: 190px;" />
      </div>
      <div class="menu-inner">
        <!-- nav aqui se quiser -->
      </div>
    </div>

  


