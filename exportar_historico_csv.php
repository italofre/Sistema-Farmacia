<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT m.id, m.tipo, m.quantidade, m.lote, m.paciente, m.data_movimentacao, med.nome AS medicamento_nome
            FROM movimentacoes m
            JOIN medicamentos med ON m.medicamento_id = med.id
            ORDER BY m.data_movimentacao DESC";

    $stmt = $pdo->query($sql);

    // Cabeçalho do CSV para download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment;filename="historico_movimentacoes.csv"');

    $saida = fopen('php://output', 'w');

    // Cabeçalho do CSV
    fputcsv($saida, ['ID', 'Medicamento', 'Lote', 'Tipo', 'Quantidade', 'Paciente', 'Data Movimentação'], ',', '"', '\\');

    // Linhas de movimentações
    while ($mov = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($saida, [
            $mov['id'],
            $mov['medicamento_nome'],
            $mov['lote'],
            ucfirst($mov['tipo']),
            $mov['quantidade'],
            $mov['paciente'] ?: '-',
            date('d/m/Y H:i', strtotime($mov['data_movimentacao']))
        ], ',', '"', '\\');
    }

    fclose($saida);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
