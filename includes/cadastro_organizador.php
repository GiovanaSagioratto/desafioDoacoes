<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include('../includes/cabecalho.php');


use App\Entity\Usuario;

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$usuarioLogado = Usuario::getUsuarioPorId($_SESSION['id_usuario']);

// Somente admins podem acessar
if ($usuarioLogado->tipo_usuario !== 'admin') {
    echo "Acesso negado. Apenas administradores podem cadastrar novos usuários.";
    exit;
}

// Lógica de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo_usuario'])) {
        $novoUsuario = new Usuario();
        $novoUsuario->nome = $_POST['nome'];
        $novoUsuario->email = $_POST['email'];
        $novoUsuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $novoUsuario->tipo_usuario = $_POST['tipo_usuario'];
        if ($_POST['tipo_usuario'] === 'organizador') {
            $novoUsuario->campanha = $_POST['campanha'] ?? null;
        } else {
            $novoUsuario->campanha = null; // não precisa de campanha
        }
        $novoUsuario->cadastrar();

        echo "<script>
    alert('Usuário cadastrado com sucesso!');
    window.location.href = 'cadastro_organizador.php'; // 
</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Organizador/Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/desafioDoacoes/assets/css/sidebar.css">

<body>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.5rem;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    </head>
    <body>

        <div class="form-container">
            <div class="form-title">Cadastro de Organizador/Admin</div>
            <form method="POST">
                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Tipo de usuário</label>
                    <select name="tipo_usuario" class="form-control" required>
                        <option value="admin">admin</option>
                        <option value="organizador">organizador</option>
                    </select>
                </div>
                <div id="campo-campanha" style="display: none;">
                    <label for="campanha">Campanha que o organizador vai gerenciar:</label>
                    <select name="campanha" class="form-control">
                        <option value="">Selecione a campanha</option>
                        <option value="campanha do agasalho">Campanha do Agasalho</option>
                        <option value="dia das crianças">Dia das Crianças</option>
                        <option value="ajude os animais">Ajude os Animais</option>
                        <option value="Doe calor e Esperança">Doe calor e Esperança</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
            </form>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tipoUsuarioSelect = document.querySelector('select[name="tipo_usuario"]');
                const campoCampanha = document.getElementById('campo-campanha');

                tipoUsuarioSelect.addEventListener('change', function () {
                    if (this.value === 'organizador') {
                        campoCampanha.style.display = 'block';
                    } else {
                        campoCampanha.style.display = 'none';
                    }
                });

                if (tipoUsuarioSelect.value === 'organizador') {
                    campoCampanha.style.display = 'block';
                }
            });
        </script>

    </body>


</html>