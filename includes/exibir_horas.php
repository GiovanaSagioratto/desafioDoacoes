<?php

require __DIR__ . '/../vendor/autoload.php';


use App\Entity\Doacao;

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
    <title>Sua Jornada PAC</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #e0f7fa, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .landing-pac {
            width: 100%;
            padding: 60px 20px 40px;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .landing-pac h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            color: #00796b;
        }

        .landing-pac p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #555;
        }

        .pac-metrics {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .pac-card {
            background: #f9f9f9;
            border-radius: 15px;
            padding: 25px 35px;
            min-width: 250px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .pac-card:hover {
            transform: translateY(-5px);
        }

        .pac-card h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .validadas {
            color: #388e3c;
            border-left: 6px solid #81c784;
        }

        .restantes {
            color: #f57c00;
            border-left: 6px solid #ffcc80;
        }
    </style>
</head>
<body>

<div class="landing-pac">
    <h1>Bem-vindo(a) à sua Jornada PAC</h1>
    <p>Acompanhe seu progresso e veja quantas horas você já conquistou!</p>

    <div class="pac-metrics">
        <div class="pac-card validadas">
            <h2><?= $totalHoras ?>h</h2>
            <span>Horas validadas ✅</span>
        </div>
        <div class="pac-card restantes">
            <h2><?= $horasRestantes ?>h</h2>
            <span>Horas restantes ⏳</span>
        </div>
    </div>
</div>

</body>
</html>