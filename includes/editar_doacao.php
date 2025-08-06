<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

include('../includes/cabecalho.php');


use App\Entity\Doacao;

// Redireciona se não estiver logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

// Verifica se recebeu o ID via GET
if (!isset($_GET['id'])) {
    echo "Doação não encontrada.";
    exit;
}

$id = (int) $_GET['id'];
$doacao = Doacao::getDoacaoPorId($id);

// Garante que o usuário só edite as próprias doações
if (!$doacao || $doacao->id_usuario != $_SESSION['id_usuario']) {
    echo "Permissão negada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Doação</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body class="p-5">
    <div class="container">
        <h2>Editar Doação</h2>
        <form action="processar_edicao.php" method="POST">
            <input type="hidden" name="id" value="<?= $doacao->id ?>">

            <div class="form-group">
                <label>Item</label>
                <input type="text" name="item" class="form-control" value="<?= htmlspecialchars($doacao->item) ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Data da Doação (não editável)</label>
                <input type="date" class="form-control" value="<?= $doacao->data ?>" disabled
                    style="background-color: #f0f0f0; cursor: not-allowed; color: #555;">
            </div>

            <div class="form-group">
                <label>Local</label>
                <input type="text" name="local" class="form-control" value="<?= htmlspecialchars($doacao->local) ?>">
            </div>

            <div class="form-group">
                <label>Observação</label>
                <textarea name="obs" class="form-control"><?= htmlspecialchars($doacao->obs) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="listagem.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>