<?php
require('fpdf/fpdf.php');

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM medicamentos WHERE estoque <= 5";
    $stmt = $pdo->query($sql);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Medicamentos com Estoque Baixo', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 7, 'ID', 1);
    $pdf->Cell(60, 7, 'Nome', 1);
    $pdf->Cell(30, 7, 'Lote', 1);
    $pdf->Cell(30, 7, 'Validade', 1);
    $pdf->Cell(20, 7, 'Estoque', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 9);

    while ($med = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pdf->Cell(10, 7, $med['id'], 1);
        $pdf->Cell(60, 7, utf8_decode($med['nome']), 1);
        $pdf->Cell(30, 7, $med['lote'], 1);
        $pdf->Cell(30, 7, $med['validade'], 1);
        $pdf->Cell(20, 7, $med['estoque'], 1);
        $pdf->Ln();
    }

    $pdf->Output();

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
