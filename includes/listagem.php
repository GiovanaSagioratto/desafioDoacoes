<?php
use App\Entity\Doacao;
session_start();
require __DIR__ . '/../vendor/autoload.php';
include('../includes/cabecalho.php');


if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$doacoes = Doacao::getDoacoesPorUsuario($id_usuario);
$statusFiltro = $_GET['status'] ?? null;
$doacoes = \App\Entity\Doacao::getDoacoesPorUsuario($id_usuario, $statusFiltro);
?>

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Sign up - srtdash</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/themify-icons.css">
<link rel="stylesheet" href="../assets/css/metisMenu.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="../assets/css/slicknav.min.css">
<!-- amchart css -->
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- others css -->
<link rel="stylesheet" href="assets/css/typography.css">
<link rel="stylesheet" href="assets/css/default-css.css">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="assets/css/responsive.css">
<!-- modernizr css -->
<script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<div class="main-content-inner">
    <div class="row">
        <!-- Basic List Group start -->
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body" style="display: flex; justify-content: center;">
                    
                    </h4>
                    <ul class="list-group">
                        <form method="GET" style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                            <label for="status" style="margin-right:0px; align-self: center;">Filtrar por
                                status:</label>
                            <select name="status" id="status" onchange="this.form.submit()" class="form-control"
                                style="width: 150px;">
                                <option value=""></option>
                                <option value="pendente" <?= isset($_GET['status']) && $_GET['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                <option value="aprovada" <?= isset($_GET['status']) && $_GET['status'] == 'aprovada' ? 'selected' : '' ?>>Aprovado</option>
                                <option value="rejeitada" <?= isset($_GET['status']) && $_GET['status'] == 'rejeitada' ? 'selected' : '' ?>>Rejeitado</option>
                            </select>
                        </form>

                        <li class="list-group-item"
                            style="display: flex; justify-content: space-between; font-weight: bold;">
                            <div style="display: flex; gap: 50px; min-width: 80%; color: #555;">
                                <span style="min-width: 120px;">Item</span>
                                <span style="min-width: 120px;">Data</span>
                                <span style="min-width: 120px;">Local</span>
                                <span style="min-width: 120px;">Observação</span>
                                <span style="min-width: 120px;">Status</span>
                            </div>
                            <div style="min-width: 100px;">Ações</div>
                            
                        </li>
                        <?php foreach ($doacoes as $row): ?>
                            <?php
                            // Normaliza o status para garantir compatibilidade
                            // Debug temporário:
                            echo "<!-- STATUS DEBUG: '" . $row->status . "' -->";
                            $status = strtolower(trim($row->status));
                            $bloquearAcoes = in_array($status, ['aprovada', 'rejeitada']);
                            $corDeFundo = $bloquearAcoes ? '#f8f9fa' : '#ffffff';
                            ?>
                            <li class="list-group-item"
                                style="display: flex; justify-content: space-between; align-items: center; background-color: <?= $corDeFundo ?>;">
                                <div style="display: flex; gap: 50px; min-width: 80%;">
                                    <span style="min-width: 120px;"><?= htmlspecialchars($row->item) ?></span>
                                    <span style="min-width: 120px;"><?= htmlspecialchars($row->data) ?></span>
                                    <span style="min-width: 120px;"><?= htmlspecialchars($row->local) ?></span>
                                    <span style="min-width: 120px;"><?= htmlspecialchars($row->obs) ?></span>
                                    <div style="min-width: 120px; display: flex; align-items: center; gap: 5px;">
                                        <span
                                            style="color: <?= $status == 'pendente' ? 'orange' : ($status == 'aprovada' ? 'green' : 'red') ?>;">
                                            <?= ucfirst($row->status) ?>
                                        </span>

                                        <?php if ($status == 'rejeitado' && !empty($row->motivo_recusa)): ?>
                                            <button class="btn btn-sm btn-outline-danger"
                                                style="padding: 2px 6px; display:inline-block;"
                                                onclick="alert('Motivo da recusa:\n<?= htmlspecialchars($row->motivo_recusa) ?>')">
                                                Ver motivo
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <?php if ($bloquearAcoes): ?>
                                        <?php if (strtolower($row->status) === 'rejeitada' && !empty($row->motivo_recusa)): ?>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="alert('Motivo da recusa: <?= htmlspecialchars($row->motivo_recusa) ?>')">Ver
                                                motivo</button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="editar_doacao.php?id=<?= $row->id ?>" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="excluir_doacao.php?id=<?= $row->id ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir esta doação?')">Excluir</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>