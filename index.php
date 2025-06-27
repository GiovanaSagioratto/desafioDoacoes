
<?php
session_start();
include '/includes/cabecalho.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Você precisa estar logado. <a href='login.php'>Login</a></p>";
    include 'includes/footer.php';
    exit;
}

if ($_SESSION['tipo_usuario'] === 'admin') {
    include 'dashboards/admin.php';
} else {
    include 'dashboards/comum.php';
}

include 'includes/footer.php';

