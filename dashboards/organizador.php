<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/cabecalho.php');

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Usuario;
use App\Entity\Doacao;

$campanhaOrganizador = $_GET['campanha'] ?? null;

if ($campanhaOrganizador) {
    $doacoesPendentes = Doacao::getDoacoesPorCampanha($campanhaOrganizador);
} else {
    $doacoesPendentes = [];
}
if (!empty($doacoesPendentes)) {
    foreach ($doacoesPendentes as $doacao) {
        echo "<div class='doacao'>";
        echo "<p>Item: {$doacao->item}</p>";
        echo "<p>Categoria: {$doacao->categoria}</p>";
        echo "<p>Observações: {$doacao->observacao}</p>";
        // E os botões de Aprovar/Recusar aqui
        echo "</div>";
    }
} else {
    echo "<p style='color: white;'>Nenhuma doação pendente para sua campanha.</p>";
}

// Verifica se está logado e é organizador
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'organizador') {
    header('Location: ../login.php');
    exit;  
}
$pendentes = Doacao::getPendentes();

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

