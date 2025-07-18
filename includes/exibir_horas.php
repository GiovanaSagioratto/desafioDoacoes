<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Doacao;
use App\Entity\Usuario;

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$doacoesAprovadas = Doacao::getDoacoesPorUsuario($id_usuario, 'aprovada');

$categoriasHoras = [
    'alimento' => 10,
    'evento'   => 20,
    'curso'    => 30,
    'ação'     => 40
];

$totalHoras = 0;
foreach ($doacoesAprovadas as $doacao) {
    $categoria = $doacao->categoria;
    $totalHoras += $categoriasHoras[$categoria] ?? 0;
}

$horasTotais = 100;
$horasRestantes = max(0, $horasTotais - $totalHoras);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Horas PAC</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        .pac-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f7f9fc;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .pac-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .pac-metric {
            font-size: 1.5em;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
        }

        .validadas {
            background-color: #d4edda;
            color: #155724;
        }

        .restantes {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>

<div class="pac-container">
    <h2>Sua Jornada PAC</h2>

    <div class="pac-metric validadas">
        ✅ Horas validadas: <strong><?= $totalHoras ?>h</strong>
    </div>

    <div class="pac-metric restantes">
        ⏳ Horas restantes: <strong><?= $horasRestantes ?>h</strong>
    </div>
</div>

</body>
</html>
