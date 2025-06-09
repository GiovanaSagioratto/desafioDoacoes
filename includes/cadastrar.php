<?php 

echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

require __DIR__.'/vendor/autoload.php';

include 'formulario.php';

use \App\Entity\doacao;

if (isset($_POST['id'])) {

  $doacao = new Doacao();

     if (!empty($_FILES['arquivo']['name'])) {
      $nomeArquivo = basename($_FILES['arquivo']['name']);
      $caminho = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $caminho)) {
          $doacao->arquivo = $caminho;
      } else {
          $doacao->arquivo = ''; 
      }
  } else {
      $doacao->arquivo = '';
  }

  $doacao->id          = $_POST['id'] ?? '';
  $doacao->id_item     = $_POST['item'] ?? '';
  $doacao->data        = $_POST['datado'] ?? '';
  $doacao->quant       = $_POST['quant'] ?? '';
  $doacao->local       = $_POST['local'] ?? '';
  $doacao->obs         = $_POST['obs'] ?? '';
  $doacao->id_usuario  = $_POST['id_usuario'] ?? '';
  
  $doacao->cadastrar();

}

?>