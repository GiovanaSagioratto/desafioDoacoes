<?php
use App\Entity\Usuario;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$usuario = Usuario::getUsuarioPorId($_SESSION['id_usuario']);
$campanhaOrganizador = $usuario->campanha ?? null;



use App\Entity\Doacao;
include('../includes/cabecalho.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['acao'])) {
    $doacao = Doacao::getDoacaoPorId($_POST['id']);

    if ($doacao) {
        if ($_POST['acao'] === 'recusar') {
            $doacao->status = 'rejeitada';
            $doacao->motivo_recusa = $_POST['motivo'] ?? 'Não informado';
        } else {
            $doacao->status = 'aprovada';
        }

        $doacao->atualizar();
    }

    header('Location:validacao.php');
    exit;
}


$doacao = Doacao::getProximaPendentePorCampanha($campanhaOrganizador);

if (!$doacao) {
    echo "<h3 style='padding:20px;'>Não há doações pendentes para validar.</h3>";
    exit;
}
$categoriasHoras = [
    'alimento' => 10,
    'evento' => 20,
    'curso' => 30,
    'ação' => 40
];
$horas = $categoriasHoras[$doacao['categoria']];

?>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Sign up - srtdash</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    .centralizado {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-top: 40px;
  text-align: center;
}
form.centralizado textarea {
  width: 300px;
  margin-bottom: 10px;
}
form.centralizado button {
  margin: 5px;
}
</style>
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
<div class="main-content-inner d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="row w-100 justify-content-center">
       <div class="col-lg-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-area">
                        <div class="invoice-head">
                            <div class="row">
                                <div class="iv-left col-6">
                                    <span>Painel de análise</span>
                                </div>
                                <div class="iv-right col-6 text-md-right">
                                    <span>#<?= htmlspecialchars($doacao['id']) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <?php
                                $usuario = \App\Entity\Usuario::getNomePorId($doacao['id_usuario']);
                                ?>
                                <h5><?= htmlspecialchars($usuario->nome ?? 'Usuário não encontrado') ?></h5>
                            </div>
                        </div>
                        <div class="invoice-table table-responsive mt-5">
                            <table class="table table-bordered table-hover text-right">
                                <thead>
                                    <tr class="text-capitalize">
                                       
                                        

                                    </tr>
                                </thead>
                                <tbody>

                                    <p><strong>Item:</strong> <?= htmlspecialchars($doacao['item']) ?></p>
                                    <p><strong>Campanha:</strong> <?= htmlspecialchars($doacao['campanha']) ?></p>
                                    <p><strong>Categoria:</strong> <?= htmlspecialchars($doacao['categoria']) ?></p>
                                    <p><strong>Observação:</strong> <?= htmlspecialchars($doacao['obs']) ?></p>
                                    <?php if ($doacao['arquivo']): ?>
                                        <p><strong>Anexo:</strong> <a href="<?= $doacao['arquivo'] ?>" target="_blank">Ver
                                                arquivo</a></p>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <form method="POST" class="invoice-buttons text-right" onsubmit="return validarFormulario()">
                        <input type="hidden" name="id" value="<?= $doacao['id'] ?>">
                        <input type="hidden" id="motivoInput" name="motivo">
                        <button type="submit" name="acao" value="aceitar" class="invoice-btn">ACEITAR</button>
                        <button type="button" class="invoice-btn" onclick="recusarComMotivo()">RECUSAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function recusarComMotivo() {
        const motivo = prompt("Informe o motivo da recusa:");
        if (motivo && motivo.trim() !== "") {
            document.getElementById('motivoInput').value = motivo;
            const form = document.querySelector('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'acao';
            input.value = 'recusar';
            form.appendChild(input);
            form.submit();
        } else {
            alert("Você precisa informar o motivo da recusa.");
        }
    }

    function validarFormulario() {
        return true;
    }
</script>