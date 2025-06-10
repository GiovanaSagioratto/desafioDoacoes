
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulário de Doações</title>
</head>
<body>
<main>
 
<h4 class="header-title">Cadastre-se</h4>  
 
<form method="POST" action="cadastrar.php" enctype="multipart/form-data">
<div class="col-12 mt-5">
<div class="card"><div class="card">
<div class="card-body">

<div class="form-group">
  <label class="col-form-label" for="id_usuario">Cadastre seu ID</label>
  <input class="form-control" id="id_usuario" name="id_usuario" value="<?= $usuario->id_usuario ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="nome">Nome</label>
  <input class="form-control" id="nome" name="nome" value="<?= $usuario->nome ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="email">E-mail</label>
  <input class="form-control" id="senha" type="email" name="email" value="<?= $usuario->email ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="senha">Senha</label>
  <input class="form-control" id="senha" type="password" name="senha" value="<?= $usuario->senha ?? '' ?>">
</div>

<div class="form-group">
  <label class="col-form-label" for="curso">Curso</label>
  <input class="form-control" id="curso" type="text" name="curso" value="<?= $usuario->curso ?? '' ?>" placeholder="EX: Engenharia de software">
</div>

<div class="form-group">
  <label class="col-form-label" for="tipo_usuario">Seu tipo</label>
  <input class="form-control" id="tipo_usuario" type="text" name="tipo_usuario" value="<?= $doacao->tipo_usuario ?? '' ?>" placeholder="Tipo do usuário (função)" list="tipos">
  <datalist id="tipos">
    <option>Usuário</option>
    <option>Administrador</option>
    <option>Organizador</option>
  </datalist>
  </div>

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