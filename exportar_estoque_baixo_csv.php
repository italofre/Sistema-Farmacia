<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM medicamentos WHERE estoque <= 5";
    $stmt = $pdo->query($sql);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment;filename="estoque_baixo.csv"');

    $saida = fopen('php://output', 'w');

    fputcsv($saida, ['ID', 'Nome', 'Lote', 'Validade', 'Estoque'], ',', '"', '\\');

    while ($med = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($saida, [$med['id'], $med['nome'], $med['lote'], $med['validade'], $med['estoque']], ',', '"', '\\');
    }

    fclose($saida);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
