<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Usuario;

$email = $_POST['email'] ?? '';

if ($email) {
    $pdo = new PDO('mysql:host=localhost;dbname=validacao', 'root', '1234');
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $existe = $stmt->fetchColumn() > 0;

    echo json_encode(['existe' => $existe]);
    exit;
}
echo json_encode(['existe' => false]);