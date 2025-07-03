<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

include 'database.php'; // esse arquivo deve conter sua conexão com o banco
include 'cabecalho.php';

$id_usuario = $_SESSION['id_usuario'];

// Consulta para buscar só as doações da pessoa logada
$sql = "SELECT id, item FROM doacoes WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
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
<div class="main-content-inner">
    <div class="row">
        <!-- Basic List Group start -->
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Lista de acompanhamento
                    </h4>
                    <ul class="list-group">
                        <ul class="list-group">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <li class="list-group-item"
                                    style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <span><?= htmlspecialchars($row['item']) ?></span>
                                    <div>
                                        <input class="btn btn-flat btn-danger btn-sm" type="reset" value="Excluir"
                                            style="margin-right: 10px;">
                                        <button class="btn btn-flat btn-success btn-sm" type="submit">Editar</button>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <input class="btn btn-flat btn-danger btn-sm" type="reset" value="Excluir"
                            style="margin-right: 10px;">
                        <button class="btn btn-flat btn-success btn-sm" type="submit">Editar</button>
                </div>
                </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>