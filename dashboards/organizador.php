<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/cabecalho.php');

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Usuario;
use App\Entity\Doacao;

// Verifica se está logado e é organizador
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'organizador') {
    header('Location: ../login.php');
    exit;
}

// Pega dados do organizador e campanha que ele gerencia
$organizador = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
$campanha = $organizador->campanha ?? null;

if (!$campanha) {
    die("Campanha do organizador não definida.");
}

// Conexão PDO
$pdo = new PDO('mysql:host=localhost;dbname=validacao;charset=utf8', 'root', '1234');

// Consulta dados só da campanha do organizador, agrupado por data
$query = "
    SELECT DATE(created_at) as data, COUNT(*) as total
    FROM doacao
    WHERE campanha = :campanha AND status = 'aprovada'
    GROUP BY DATE(created_at)
    ORDER BY data ASC
";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':campanha', $campanha);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pega todas as datas para o eixo X (labels)
$labels = array_column($resultados, 'data');

// Pega os totais das doações aprovadas por data para o dataset
$valores = array_map(fn($item) => (int)$item['total'], $resultados);

$labelsJSON = json_encode($labels);
$valoresJSON = json_encode($valores);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Organizador - <?= htmlspecialchars($campanha) ?></title>

    <!-- Metatags, CSS e scripts iguais ao admin.php -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div style="display: flex; justify-content: center; align-items: center; height: 90vh; margin-left: 30vh">
    <div style="width: 100%; max-width: 900px;">
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="header-title" style="text-align: center;">Evolução das Doações - Campanha <?= htmlspecialchars($campanha) ?></h4>
                <canvas id="graficoCampanhaOrganizador" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar e Menu igual admin.php -->

<div class="page-container">
    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <img src="../assets/images/author/logopaCControl.png"
                style="width: 100%; max-width: 200px; margin: 20px auto; display: block;" />
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                
            </div>
        </div>
    </div>
</div>

<!-- Script do gráfico -->
<script>
    const labels = <?= $labelsJSON ?>;
    const dados = <?= $valoresJSON ?>;

    const ctx = document.getElementById('graficoCampanhaOrganizador').getContext('2d');
    const grafico = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doações aprovadas',
                data: dados,
                borderColor: '#36a2eb',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Evolução da Campanha: <?= addslashes(htmlspecialchars($campanha)) ?>'
                },
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Data'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Número de Doações'
                    },
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

<!-- JS e scripts finais idênticos ao admin.php -->
<script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/metisMenu.min.js"></script>
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/jquery.slicknav.min.js"></script>

<script>
    $(document).ready(function () {
        $('#menu').metisMenu();
    });
</script>

</body>
</html>