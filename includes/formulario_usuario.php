<!doctype html>
<html class="no-js" lang="en">

<head>
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
  <link rel="stylesheet" href="assets/css/typography.css">
  <link rel="stylesheet" href="assets/css/default-css.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
  <div id="preloader">
    <div class="loader"></div>
  </div>

  <div class="login-area login-s2">
    <div class="container">
      <div class="login-box ptb--100">
        <form id="form-cadastro" method="POST" action="cadastrar_usuario.php">
          <div class="login-form-head">
            <h4>Cadastre-se</h4>
            <p>Cadastre-se para ter acesso às doações</p>
          </div>

          <div class="form-group">
            <label for="nome">Nome</label>
            <input class="form-control" id="nome" name="nome" value="<?= $usuario->nome ?? '' ?>" required>
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" id="email" type="email" name="email" value="<?= $usuario->email ?? '' ?>" required>
            <div id="msg-email" style="color:red; margin-bottom:10px;"></div>
          </div>

          <div class="form-group">
            <label for="senha">Senha</label>
            <input class="form-control" id="senha" type="password" name="senha" required>
          </div>

          <div class="form-group">
            <label for="curso">Curso</label>
            <input class="form-control" id="curso" type="text" name="curso" value="<?= $usuario->curso ?? '' ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  </div>

 
  <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#form-cadastro').on('submit', function (e) {
        e.preventDefault(); 

        let email = $('#email').val();

        $.post('verifica_email.php', { email: email }, function (data) {
          let resposta = JSON.parse(data);
          if (resposta.existe) {
            $('#msg-email').text('Este e-mail já está cadastrado.');
          } else {
            $('#msg-email').text('');
            $('#form-cadastro')[0].submit(); 
          }
        });
      });
    });
  </script>

 
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/owl.carousel.min.js"></script>
  <script src="../assets/js/metisMenu.min.js"></script>
  <script src="../assets/js/jquery.slimscroll.min.js"></script>
  <script src="../assets/js/jquery.slicknav.min.js"></script>
  <script src="../assets/js/plugins.js"></script>
  <script src="../assets/js/scripts.js"></script>
</body>

</html>