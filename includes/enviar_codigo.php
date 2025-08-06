<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include('../includes/cabecalho.php');

use App\Db\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// E-mail informado pelo usuário
$email = $_POST['email'] ?? '';

if (empty($email)) {
    $_SESSION['recuperar_erro'] = "Informe o e-mail.";
    header('Location: recuperar_senha.php');
    exit;
}

// Conexão com banco
$db = new Database('usuario');
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $codigo = rand(100000, 999999);
    $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $stmt = $pdo->prepare("UPDATE usuario SET codigo_recuperacao = :codigo, codigo_expira = :expira WHERE email = :email");
    $stmt->execute([
        ':codigo' => $codigo,
        ':expira' => $expira,
        ':email' => $email
    ]);

    // Enviar e-mail com PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';           // Se quiser outro, substitua aqui
        $mail->SMTPAuth = true;
        $mail->Username = 'sagiorattogiovana@gmail.com';   // ✅ SEU E-MAIL
        $mail->Password = 'rwxj kgml wmsq nfqx';            // ✅ SENHA DE APLICATIVO do Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('seuemail@gmail.com', 'Sistema de Doações');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Código de recuperação de senha';
        $mail->Body    = "<p>Olá,</p><p>Seu código de recuperação é: <strong>$codigo</strong></p><p>Este código expira em 15 minutos.</p>";

        $mail->send();

        $_SESSION['email_recuperacao'] = $email;
        header('Location: redefinir_senha.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['recuperar_erro'] = "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        header('Location: recuperar_senha.php');
        exit;
    }
} else {
    $_SESSION['recuperar_erro'] = "E-mail não encontrado.";
    header('Location: recuperar_senha.php');
    exit;
}