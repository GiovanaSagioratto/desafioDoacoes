<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Usuario;

$id = $_SESSION['id_usuario'];

if (isset($_POST['salvar'])) {
    $usuario = Usuario::getUsuarioPorId($id);

    if ($_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $nomeTemp = $_FILES['foto_perfil']['tmp_name'];
        $nomeFinal = uniqid() . '_' . $_FILES['foto_perfil']['name'];

        $destino = '../uploads/' . $nomeFinal;
        move_uploaded_file($nomeTemp, $destino);

        $usuario->foto_perfil = $destino;
    }

    $usuario->atualizar();

    header('Location: editar_usuario.php?sucesso=1');
    exit;
}

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario->nome = $_POST['nome'];

    // Processar upload de imagem
    if (!empty($_FILES['foto']['name'])) {
        $nomeArquivo = uniqid() . '-' . $_FILES['foto']['name'];
        $caminhoDestino = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
            $usuario->foto_perfil = $caminhoDestino;
        }
    }

    $usuario->atualizar();

    header('Location: editar_usuario.php?atualizado=1');
    exit;
}
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
<h2>Editar Perfil</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($usuario->nome) ?>"><br><br>

    <label>Foto de perfil:</label><br>
    <?php if ($usuario->foto_perfil): ?>
        <img src="<?= $usuario->foto_perfil ?>" width="100" height="100"><br>
    <?php endif; ?>
    <input type="file" name="foto"><br><br>

    <form method="POST" enctype="multipart/form-data">
  <input type="file" name="foto_perfil">
  <button type="submit" name="salvar">Salvar</button>
</form>
</form>