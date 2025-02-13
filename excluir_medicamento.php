<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

if (isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_GET['id'];

        // Verificar se o medicamento tem movimentações (se tiver, pode optar por não excluir)
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM movimentacoes WHERE medicamento_id = ?");
        $stmtCheck->execute([$id]);
        $movCount = $stmtCheck->fetchColumn();

        if ($movCount > 0) {
            echo "<p>Esse medicamento possui movimentações e não pode ser excluído.</p>";
            echo '<a href="consulta_estoque.php" class="btn btn-secondary">Voltar</a>';
        } else {
            // Excluir medicamento
            $stmt = $pdo->prepare("DELETE FROM medicamentos WHERE id = ?");
            $stmt->execute([$id]);

            header('Location: consulta_estoque.php');
            exit;
        }
    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    echo "ID não informado.";
}
?>
