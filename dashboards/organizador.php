<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/cabecalho.php');

require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Doacao;
$pdo = new PDO('mysql:host=localhost;dbname=validacao;charset=utf8', 'root', '1234');

// Consulta para obter contagem por dia e campanha
$query = "
    SELECT campanha, DATE(created_at) as data, COUNT(*) as total
    FROM doacao
    GROUP BY campanha, DATE(created_at)
    ORDER BY data ASC;
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organizar os dados por campanha
$dadosPorCampanha = [];

foreach ($resultados as $linha) {
    if ($linha['campanha'] === null)
        continue; 

    $campanha = $linha['campanha'];
    $data = $linha['data'];
    $total = $linha['total'];

    if (!isset($dadosPorCampanha[$campanha])) {
        $dadosPorCampanha[$campanha] = [];
    }

    $dadosPorCampanha[$campanha][$data] = $total;
}

// Gerar listas de datas e contagens
$labels = array_unique(array_column($resultados, 'data'));
sort($labels);

$datasets = [];

$cores = ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'];
$i = 0;

foreach ($dadosPorCampanha as $campanha => $datas) {
    $valores = [];

    foreach ($labels as $data) {
        $valores[] = $datas[$data] ?? 0;
    }

    $datasets[] = [
        'label' => $campanha,
        'data' => $valores,
        'borderColor' => $cores[$i % count($cores)],
        'fill' => false
    ];

    $i++;
}

// Enviar dados para o JavaScript
$labelsJSON = json_encode($labels);
$datasetsJSON = json_encode($datasets);

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'organizador') {
    header('Location: ../login.php');
    exit;
}
$pendentes = Doacao::getPendentes();
?>
<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>srtdash - ICO Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS -->
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

<!-- JS Modernizr -->
<script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Div centralizadora -->


<!-- Main Content -->

<!-- Page Container -->

<div class="page-container">
    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <img src="../assets/images/author/logopaCControl.png"
                style="width: 100%; max-width: 200px; margin: 20px auto; display: block;" />
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    
                </nav>
            </div>
        </div>

    </div>
    <script>
        const labels = <?php echo $labelsJSON; ?>;
        const datasets = <?php echo $datasetsJSON; ?>;

        const ctx = document.getElementById('graficoCampanhas').getContext('2d');
        const graficoCampanhas = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Doações por Campanha ao Longo do Tempo'
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




    <!-- JS Scripts -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- Ativa o menu -->
    <script>
        $(document).ready(function () {
            $('#menu').metisMenu();
        });
    </script>