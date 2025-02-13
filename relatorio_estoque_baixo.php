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
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório - Estoque Baixo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include 'cabecalho.php'; ?>

<body class="container mt-5">

<h2>Medicamentos com Estoque Baixo (≤ 5 unidades)</h2>

<a href="exportar_estoque_baixo_csv.php" class="btn btn-success mb-3">Exportar para CSV</a>
<a href="exportar_estoque_baixo_pdf.php" class="btn btn-danger mb-3">Exportar para PDF</a>


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
        <tr class="table-danger">
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
