<?php
ob_start();
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Doacao;
use App\Entity\Usuario;

// Verifica se foi passado o ID
$id = $_GET['id_usuario'] ?? null;

if (!$id) {
    exit("ID inválido.");
}

// Busca o usuário e suas doações
$usuario = Usuario::getUsuarioPorId($id);
$doacoes = Doacao::getDoacoesPorUsuario($id);

// Horas PAC por categoria
$horasPorCategoria = [
    'alimento' => 10,
    'evento'   => 20,
    'curso'    => 30,
    'ação'     => 40
];

$totalHorasValidadas = 0;

// Geração do HTML
$html = "<h2>Relatório de Doações - {$usuario->nome}</h2>";
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
$html .= "<h3>Total de horas validadas: {$totalHorasValidadas}h</h3>";
$html .= "<h4>Faltam: " . max(0, 100 - $totalHorasValidadas) . "h para completar 100h</h4>";

// Configuração do DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

ob_end_clean();

$dompdf->render();
$dompdf->stream("relatorio-usuario-{$usuario->id_usuario}.pdf", ["Attachment" => false]);
exit;