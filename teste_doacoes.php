<?php
$pdo = new PDO('mysql:host=localhost;dbname=validacao;charset=utf8', 'root', '1234');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_usuario = 2; // Altere para seu ID real
$status = 'aprovado';

$stmt = $pdo->prepare("SELECT * FROM doacao WHERE id_usuario = :id AND status = :status");
$stmt->execute([
    ':id' => $id_usuario,
    ':status' => $status
]);

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($resultado);
echo "</pre>";