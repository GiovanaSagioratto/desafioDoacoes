<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use App\Entity\Doacao;
use App\Entity\Usuario;

$id = $_GET['id_usuario'] ?? null;

if (!$id) {
    exit("ID inválido.");
}

$usuario = Usuario::getUsuarioPorId($id);
$doacoes = Doacao::getDoacoesPorUsuario($id);

$html = "<h2>Relatório de Doações - {$usuario->nome}</h2>";
$html .= "<table border='1' width='100%' cellpadding='5'><tr><th>Item</th><th>Categoria</th><th>Status</th></tr>";

foreach ($doacoes as $doacao) {
    $html .= "<tr>
                <td>{$doacao->item}</td>
                <td>{$doacao->categoria}</td>
                <td>{$doacao->status}</td>
              </tr>";
}
$html .= "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio-usuario-{$usuario->id}.pdf", ["Attachment" => false]);