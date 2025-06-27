<?php 


require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\doacao;

$conn = new mysqli("localhost", "root", "1234", "validacao");


if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['item'], $_POST['data'], $_POST['quant'], $_POST['local'], $_POST['obs'], $_POST['id_usuario'])) {
  $doacao = new Doacao();

     if (!empty($_FILES['arquivo']['name'])) {
      $nomeArquivo = basename($_FILES['arquivo']['name']);
      $caminho = 'uploads/' . $nomeArquivo;

      if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho)) {
          $doacao->arquivo = $caminho;
      } else {
          $doacao->arquivo = ''; 
      }
  } else {
      $doacao->arquivo = '';
  }

  $doacao->id          = $_POST['id'] ?? '';
  $doacao->item        = $_POST['item'] ?? '';
  $doacao->data        = $_POST['data'] ?? '';
  $doacao->quant       = $_POST['quant'] ?? '';
  $doacao->local       = $_POST['local'] ?? '';
  $doacao->obs         = $_POST['obs'] ?? '';

  session_start();
  $doacao->id_usuario = $_SESSION['id_usuario'] ?? null;
  
  $doacao->cadastrar();

}



?>