<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Usuario;

session_start();

$usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = 'foto_' . $_SESSION['id_usuario'] . '.' . $extensao;
        $caminho = '../uploads/' . $nomeArquivo;

        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho);

        // Salva no banco o caminho relativo
        $usuario->foto_perfil = $caminho;
        $usuario->atualizar(); // função que atualiza o usuário no banco
        header('Location: admin.php');
        exit;
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <label>Escolha uma nova foto de perfil:</label><br>
    <input type="file" name="foto_perfil" required><br><br>
    <button type="submit">Salvar</button>
</form>