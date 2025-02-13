<?php

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Carregar medicamento específico
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM medicamentos WHERE id = ?");
        $stmt->execute([$id]);
        $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$medicamento) {
            die("Medicamento não encontrado.");
        }
    }

    // Atualizar dados
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $lote = $_POST['lote'];
        $validade = $_POST['validade'];
        $estoque = $_POST['estoque'];

        $stmt = $pdo->prepare("UPDATE medicamentos SET nome = ?, lote = ?, validade = ?, estoque = ? WHERE id = ?");
        $stmt->execute([$nome, $lote, $validade, $estoque, $id]);

        header('Location: consulta_estoque.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include 'cabecalho.php'; ?>

<body class="container mt-5">

<h2>Editar Medicamento</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $medicamento['id']; ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Medicamento</label>
        <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($medicamento['nome']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="lote" class="form-label">Lote</label>
        <input type="text" class="form-control" name="lote" value="<?= htmlspecialchars($medicamento['lote']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="validade" class="form-label">Validade</label>
        <input type="date" class="form-control" name="validade" value="<?= $medicamento['validade']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="estoque" class="form-label">Quantidade em Estoque</label>
        <input type="number" class="form-control" name="estoque" value="<?= $medicamento['estoque']; ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar Alterações</button>
    <a href="consulta_estoque.php" class="btn btn-secondary">Cancelar</a>
</form>

</body>

</html>
