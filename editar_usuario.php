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

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Buscar grupos para o select
    $grupos = $pdo->query("SELECT * FROM grupos")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $grupo_id = $_POST['grupo_id'];

        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, grupo_id = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $grupo_id, $id]);

        header('Location: listar_usuarios.php?mensagem=Usuário atualizado com sucesso!&tipo=success');
        exit;
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Editar Usuário</h2>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Grupo</label>
                            <select name="grupo_id" class="form-control" required>
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= $grupo['id']; ?>" <?= ($usuario['grupo_id'] == $grupo['id']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($grupo['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="listar_usuarios.php" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
