<?php
include('../includes/cabecalho.php');
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  select.form-control {
  height: calc(2.25rem + 2px); /* mesma altura dos inputs padrão */
  padding: 0.375rem 0.75rem;   /* centraliza verticalmente */
  line-height: 1.5;            /* mantém texto central */
}
</style>


<div id="mensagemSucesso" style="
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    background: #4CAF50;
    color: white;
    padding: 20px 40px;
    font-size: 24px;
    border-radius: 10px;
    text-align:center;
    box-shadow:0px 4px 10px rgba(0,0,0,0.2);
    z-index:9999;
">
  ✅ Cadastro efetuado com sucesso!
</div>
<script>
  $(document).ready(function () {
    $("form[action='cadastrar.php']").on("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        url: "cadastrar.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (resposta) {
          Swal.fire({
            icon: 'success',
            title: 'Cadastro efetuado!',
            text: 'Sua doação foi registrada com sucesso.',
            showConfirmButton: false,
            timer: 2000
          });

          $("form[action='cadastrar.php']")[0].reset();
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Ocorreu um erro ao cadastrar a doação.'
          });
        }
      });
    });
  });
</script>

<div style="padding: 40px; max-width: 800px; margin: 0 auto;">
  <h4>Cadastre sua doação</h4>
  <form method="POST" action="cadastrar.php" enctype="multipart/form-data">
    <div class="card">
      <div class="card-body">

        <div class="form-group">
          <label class="col-form-label" for="item">Item doado</label>
          <input class="form-control" id="item" name="item" value="<?= $doacao->item ?? '' ?>">
        </div>
        <div class="form-group">
          <label class="col-form-label" for="categoria">Categoria</label>
          <select class="form-control" id="categoria" name="categoria" required>
            <option value="">Selecione</option>
            <option value="alimento" <?= (isset($doacao->categoria) && $doacao->categoria === 'alimento') ? 'selected' : '' ?>>Alimento</option>
            <option value="evento" <?= (isset($doacao->categoria) && $doacao->categoria === 'evento') ? 'selected' : '' ?>>
              Evento</option>
            <option value="curso" <?= (isset($doacao->categoria) && $doacao->categoria === 'curso') ? 'selected' : '' ?>>
              Curso</option>
            <option value="ação" <?= (isset($doacao->categoria) && $doacao->categoria === 'ação') ? 'selected' : '' ?>>Ação
            </option>
          </select>
        </div>
        <label for="campanha">Campanha:</label>
        <select name="campanha" id="campanha" class="form-control" required>
          <option value="">Selecione</option>
          <option value="Campanha do Agasalho">Campanha do Agasalho</option>
          <option value="Dia das Crianças">Dia das Crianças</option>
          <option value="Ajude os Animais">Ajude os Animais</option>
          <option value="Doe Calor e Esperança">Doe Calor e Esperança</option>
        </select>
        <div class="form-group">
          <label class="col-form-label" for="datado">Data da doação</label>
          <input class="form-control" id="data" type="date" name="data" value="<?= date('Y-m-d') ?>" readonly>
        </div>

        <div class="form-group">
          <label class="col-form-label" for="local">Local de entrega</label>
          <input class="form-control" id="local" type="text" name="local" value="<?= $doacao->local ?? '' ?>"
            placeholder="Ex: portaria">
        </div>

        <div class="form-group">
          <label class="col-form-label" for="anexo">Anexo</label>
          <input class="form-control" id="arquivo" type="file" name="arquivo" value="<?= $doacao->anexo ?? '' ?>">
        </div>

        <div class="form-group">
          <label class="col-form-label" for="obs">Observação</label>
          <input class="form-control" id="obs" type="text" name="obs" value="<?= $doacao->obs ?? '' ?>"
            placeholder="Informação que considere importante sabermos sobre a doação">
        </div>

        <form action="cadastrar.php" method="POST">
          <!-- Seus campos do formulário aqui -->

          <div class="form-group">
            <button type="submit">Enviar</button>
          </div>
        </form>
  </form>
</div>

</div>
</div>
</div>

</div>
< </div>
  </body>

  </html>
  </main>
  </body>

  </html>