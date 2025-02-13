<?php
session_start();

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $paciente_id = $_POST['paciente_id'];
    $medicamento_id = $_POST['medicamento_id'];
    $data_aplicacao = $_POST['data_aplicacao'];
    $periodicidade = $_POST['periodicidade'];
    $quantidade = $_POST['quantidade'];

    $data_proxima_aplicacao = date('Y-m-d', strtotime("$data_aplicacao + $periodicidade days"));
    $data_sugerida_compra = date('Y-m-d', strtotime("$data_proxima_aplicacao - 5 days"));

    // Inserir aplicação
    $stmt = $pdo->prepare("INSERT INTO aplicacoes (paciente_id, medicamento_id, data_aplicacao, periodicidade, data_proxima_aplicacao, data_sugerida_compra, quantidade) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$paciente_id, $medicamento_id, $data_aplicacao, $periodicidade, $data_proxima_aplicacao, $data_sugerida_compra, $quantidade]);

    // Dar baixa no estoque
    $stmt_baixa = $pdo->prepare("UPDATE medicamentos SET estoque = estoque - ? WHERE id = ?");
    $stmt_baixa->execute([$quantidade, $medicamento_id]);

    header('Location: aplicacao_medicamento.php?mensagem=Aplicação registrada com sucesso e estoque atualizado!&tipo=success');
    exit;
} catch (PDOException $e) {
    header('Location: aplicacao_medicamento.php?mensagem=Erro ao registrar aplicação!&tipo=danger');
    exit;
}
