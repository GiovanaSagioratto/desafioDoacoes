<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Doacao;
include('../includes/cabecalho.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['acao'])) {
    $doacao = Doacao::getDoacaoPorId($_POST['id']);
    if ($doacao) {
        $novoStatus = ($_POST['acao'] === 'aceitar') ? 'aprovada' : 'rejeitada';
        $doacao->status = $novoStatus;
        $doacao->atualizar();
    }

    header('Location:validacao.php');
    exit;
}


$doacao = Doacao::getProximaPendente();

if (!$doacao) {
    echo "<h3 style='padding:20px;'>Não há doações pendentes para validar.</h3>";
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
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-area">
                        <div class="invoice-head">
                            <div class="row">
                                <div class="iv-left col-6">
                                    <span>Painel de análise</span>
                                </div>
                                <div class="iv-right col-6 text-md-right">
                                    <span>#<?= htmlspecialchars($doacao->id) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="invoice-address">
                                    <h3>Doado por</h3>
                                    <h5>Verdie Hintz</h5>
                                    <p>4494 Weekley Street, San Antonio, 78205 Texas</p>
                                    <p>San Antonio</p>
                                    <p>Somalia</p>
                                </div>
                            </div>

                        </div>
                        <div class="invoice-table table-responsive mt-5">
                            <table class="table table-bordered table-hover text-right">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th class="text-center" style="width: 5%;">id</th>
                                        <th class="text-left" style="width: 45%; min-width: 130px;">description</th>
                                        <th>qty</th>
                                        <th style="min-width: 100px">Unit Cost</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($doacao->id) ?></td>
                                        <td class="text-left"><?= htmlspecialchars($doacao->item) ?></td>
                                        <td><?= htmlspecialchars($doacao->quant) ?></td>
                                        <td>R$0,00</td> <!-- você pode substituir isso se tiver valor -->
                                        <td>R$0,00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">total balance :</td>
                                        <td>$140</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <form method="POST" class="invoice-buttons text-right">
                        <input type="hidden" name="id" value="<?= $doacao->id ?>">
                        <button name="acao" value="aceitar" class="invoice-btn">ACEITAR</button>
                        <button name="acao" value="recusar" class="invoice-btn">RECUSAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>