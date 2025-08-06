<?php
ob_start();
require __DIR__ . '/../vendor/autoload.php';
include('../includes/cabecalho.php');

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Doacao;
use App\Entity\Usuario;

// Mapeia horas PAC por categoria
$horasPorCategoria = [
    'alimento' => 10,
    'evento'   => 20,
    'curso'    => 30,
    'ação'     => 40
];

$usuarios = Usuario::getUsuariosPorTipo('comum'); // <-- Este método deve retornar todos os usuários do sistema

$html = "<h1>Relatório Geral de Doações</h1>";

foreach ($usuarios as $usuario) {
    $doacoes = Doacao::getDoacoesPorUsuario($usuario->id_usuario); // Ou o nome correto da propriedade

    $totalHorasValidadas = 0;

    $html .= "<h2>Usuário: {$usuario->nome}</h2>";
    $html .= "<p>Email: {$usuario->email}</p>";
    $html .= "<hr>";
    $html .= "<table border='1' width='100%' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Horas PAC</th>
                    </tr>
                </thead>
                <tbody>";

    foreach ($doacoes as $doacao) {
        $horas = $horasPorCategoria[$doacao->categoria] ?? 0;

        if ($doacao->status === 'aprovado') {
            $totalHorasValidadas += $horas;
        }

        $html .= "<tr>
                    <td>{$doacao->item}</td>
                    <td>{$doacao->categoria}</td>
                    <td>{$doacao->status}</td>
                    <td>{$horas} horas</td>
                  </tr>";
    }

    $html .= "</tbody></table><br>";
    $html .= "<strong>Total de horas validadas: {$totalHorasValidadas}h</strong><br>";
    $html .= "<strong>Faltam: " . max(0, 100 - $totalHorasValidadas) . "h para completar 100h</strong>";
    $html .= "<hr><br><br>";
}

// Geração do PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

ob_end_clean();

$dompdf->render();
$dompdf->stream("relatorio-geral-doacoes.pdf", ["Attachment" => false]);
exit;