<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/cabecalho.php');

require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Doacao;

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
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
        <!-- Main Content -->
        <!-- Page Container -->
    <div class="page-container">
        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <img src="../assets/images/author/logopaCControl.png" style="width: 100%; max-width: 200px; margin: 20px auto; display: block;" />
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">                         
                          
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


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