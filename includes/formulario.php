
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulário de Doações</title>
</head>
<body>
<main>
 
<h4 class="header-title">Cadastre sua doação</h4>  
 
<form method="POST" action="cadastrar.php" enctype="multipart/form-data">
<div class="col-12 mt-5">
<div class="card"><div class="card">
<div class="card-body">

<div class="form-group">
  <label class="col-form-label" for="id">Id da doação</label>
  <input class="form-control" id="id" name="id" value="<?= $doacao->id ?? '' ?>">
</div>

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
  <input class="form-control" id="datado" type="date" name="datado" value="<?= $doacao->datado ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="local">Local de entrega</label>
  <input class="form-control" id="local" type="text" name="local" value="<?= $doacao->local ?? '' ?>" placeholder="Ex: portaria">
</div>

<div class="form-group">
  <label class="col-form-label" for="anexo">Anexo</label>
  <input class="form-control" id="anexo" type="file" name="anexo" value="<?= $doacao->anexo ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="obs">Observação</label>
  <input class="form-control" id="obs" type="text" name="obs" value="<?= $doacao->obs ?? '' ?>" placeholder="Informação que considere importante sabermos sua participação.">
</div>

<div class="form-group">
  <label class="col-form-label" for="id_usuario">Seu ID</label>
  <input class="form-control" id="id_usuario" type="text" name="id_usuario" value="<?= $doacao->id_usuario ?? '' ?>" placeholder="Identificação do usuário">

  <button type="submit">Enviar</button>
</div>
</form>                           
    </div>
    
        </div> 
            </div>
 </div>

</main>
</body>
</html>