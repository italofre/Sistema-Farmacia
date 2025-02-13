<?php
session_start();

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    $stmt = $pdo->prepare("INSERT INTO pacientes (nome, cpf, telefone) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $cpf, $telefone]);

    header('Location: cadastro_paciente.php?mensagem=Paciente cadastrado com sucesso!&tipo=success');
    exit;
} catch (PDOException $e) {
    header('Location: cadastro_paciente.php?mensagem=Erro ao cadastrar paciente!&tipo=danger');
    exit;
}

