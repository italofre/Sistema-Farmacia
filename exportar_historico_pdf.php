<?php
require('fpdf/fpdf.php');

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

    // Criação do PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Historico de Movimentacoes', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 7, 'ID', 1);
    $pdf->Cell(40, 7, 'Medicamento', 1);
    $pdf->Cell(20, 7, 'Tipo', 1);
    $pdf->Cell(25, 7, 'Lote', 1);
    $pdf->Cell(20, 7, 'Qtd', 1);
    $pdf->Cell(35, 7, 'Paciente', 1);
    $pdf->Cell(40, 7, 'Data', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 9);

    while ($mov = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pdf->Cell(10, 7, $mov['id'], 1);
        $pdf->Cell(40, 7, utf8_decode($mov['medicamento_nome']), 1);
        $pdf->Cell(20, 7, ucfirst($mov['tipo']), 1);
        $pdf->Cell(25, 7, $mov['lote'], 1);
        $pdf->Cell(20, 7, $mov['quantidade'], 1);
        $pdf->Cell(35, 7, $mov['paciente'] ?: '-', 1);
        $pdf->Cell(40, 7, date('d/m/Y H:i', strtotime($mov['data_movimentacao'])), 1);
        $pdf->Ln();
    }

    $pdf->Output();

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
