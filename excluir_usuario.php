<?php
include 'cabecalho.php';

if ($_SESSION['grupo'] !== 'admin') {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar esta página.</div>";
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

    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: listar_usuarios.php');
    exit;
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
