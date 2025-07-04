<?php 
include 'cabecalho.php';
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
  <label class="col-form-label" for="quant">Quantidade</label>
  <input class="form-control" id="quant" type="number" name="quant" value="<?= $doacao->quant ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="datado">Data da doação</label>
  <input class="form-control" id="data" type="date" name="data" value="<?= $doacao->datado ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="local">Local de entrega</label>
  <input class="form-control" id="local" type="text" name="local" value="<?= $doacao->local ?? '' ?>" placeholder="Ex: portaria">
</div>

<div class="form-group">
  <label class="col-form-label" for="anexo">Anexo</label>
  <input class="form-control" id="arquivo" type="file" name="arquivo" value="<?= $doacao->anexo ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="obs">Observação</label>
  <input class="form-control" id="obs" type="text" name="obs" value="<?= $doacao->obs ?? '' ?>" placeholder="Informação que considere importante sabermos sua participação.">
</div>

<div class="form-group">
  <button type="submit">Enviar</button>
</div>
</form>                           
    </div>
    
        </div> 
            </div>
 </div>

  </div> <
</div> 
</body>
</html>
</main>
</body>
</html>