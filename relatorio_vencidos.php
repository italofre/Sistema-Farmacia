<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM medicamentos WHERE validade < CURDATE()";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório - Medicamentos Vencidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Medicamentos Vencidos</h2>

<a href="exportar_vencidos_csv.php" class="btn btn-success mb-3">Exportar para CSV</a>
<a href="exportar_vencidos_pdf.php" class="btn btn-danger mb-3">Exportar para PDF</a>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Lote</th>
        <th>Validade</th>
        <th>Estoque</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($med = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr class="table-warning">
            <td><?= $med['id']; ?></td>
            <td><?= htmlspecialchars($med['nome']); ?></td>
            <td><?= htmlspecialchars($med['lote']); ?></td>
            <td><?= $med['validade']; ?></td>
            <td><?= $med['estoque']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<a href="index.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>

</body>

</html>
