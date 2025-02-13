<?php
session_start();

if ($_SESSION['grupo'] !== 'admin') {
    header('Location: index.php?mensagem=Acesso não autorizado!&tipo=danger');
    exit;
}

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $pdo->prepare("UPDATE pacientes SET ativo = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    $mensagem = $status ? 'Paciente ativado com sucesso!' : 'Paciente inativado com sucesso!';
    header('Location: listar_pacientes.php?mensagem=' . urlencode($mensagem) . '&tipo=success');
    exit;
} catch (PDOException $e) {
    header('Location: listar_pacientes.php?mensagem=Erro ao alterar status do paciente.&tipo=danger');
    exit;
}
