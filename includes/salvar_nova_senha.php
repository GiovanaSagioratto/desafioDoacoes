<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
use App\Db\Database;

$email = $_SESSION['email_recuperacao'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';

if (!$email || !$codigo || !$novaSenha) {
    $_SESSION['erro_codigo'] = "Campos obrigatórios.";
    header('Location: redefinir_senha.php');
    exit;
}

$db = new Database('usuario');
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT codigo_recuperacao, codigo_expira FROM usuario WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if ($dados && $codigo == $dados['codigo_recuperacao'] && strtotime($dados['codigo_expira']) > time()) {
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE usuario SET senha = :senha, codigo_recuperacao = NULL, codigo_expira = NULL WHERE email = :email");
    $stmt->execute([
        ':senha' => $senhaHash,
        ':email' => $email
    ]);

    unset($_SESSION['email_recuperacao']);
    $_SESSION['mensagem'] = 'Senha atualizada com sucesso!';
    header('Location: /desafioDoacoes/login.php');
    exit;
} else {
    $_SESSION['erro_codigo'] = "Código inválido ou expirado.";
    header('Location: redefinir_senha.php');

    exit;
}