<?php
session_start();

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];
    $status = $_GET['status']; // 1 para ativar, 0 para inativar

    $stmt = $pdo->prepare("UPDATE medicamentos SET ativo = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    $mensagem = $status ? 'Medicamento ativado com sucesso!' : 'Medicamento inativado com sucesso!';
    header('Location: consulta_estoque.php?mensagem=' . urlencode($mensagem) . '&tipo=success');
    exit;

} catch (PDOException $e) {
    header('Location: consulta_estoque.php?mensagem=Erro ao alterar status do medicamento.&tipo=danger');
    exit;
}
