<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Usuario;

$usuarios = Usuario::getUsuariosPorTipo('comum');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatórios de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Relatórios de Usuários Comuns</h1>
            <a href="../includes/gerar_relatorio.php" target="_blank" class="btn btn-success">
                📄 Gerar Relatório Geral
            </a>
        </div>

        <?php if (empty($usuarios)): ?>
            <div class="alert alert-warning text-center">
                Nenhum usuário comum encontrado.
            </div>
        <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Curso</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario->nome) ?></td>
                            <td><?= htmlspecialchars($usuario->email) ?></td>
                            <td><?= htmlspecialchars($usuario->curso) ?></td>
                            <td>
                                <a href="../includes/relatorio_individual.php?id_usuario=<?= $usuario->id_usuario ?>" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    Relatório Individual
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>