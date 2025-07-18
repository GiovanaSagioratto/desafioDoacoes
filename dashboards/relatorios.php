<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Usuario;

$usuarios = Usuario::getUsuariosPorTipo('comum');



<h1>Relatórios de Usuários</h1>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>
    
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->nome ?></td>
            <td><?= $usuario->email ?></td>
            <td>
               <a href="gerar_relatorio.php?id_usuario=<?= $usuario->id_usuario ?>" target="_blank">Gerar PDF</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>