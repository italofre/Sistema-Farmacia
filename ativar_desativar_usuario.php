<?php
include 'cabecalho.php';

if ($_SESSION['grupo'] !== 'admin') {
    echo "Você não tem permissão.";
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
    $acao = $_GET['acao']; // ativar ou desativar

    $novoStatus = ($acao === 'ativar') ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE usuarios SET ativo = ? WHERE id = ?");
    $stmt->execute([$novoStatus, $id]);

    header('Location: listar_usuarios.php');
    exit;
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
