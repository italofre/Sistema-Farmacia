<?php include 'cabecalho.php'; ?>

<?php
if ($_SESSION['grupo'] !== 'admin') {
    header('Location: index.php?mensagem=Acesso não autorizado!&tipo=danger');
    exit;
}
?>


$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        header('Location: listar_pacientes.php?mensagem=Paciente não encontrado.&tipo=danger');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];

        $stmt = $pdo->prepare("UPDATE pacientes SET nome = ?, cpf = ?, telefone = ? WHERE id = ?");
        $stmt->execute([$nome, $cpf, $telefone, $id]);

        header('Location: listar_pacientes.php?mensagem=Paciente atualizado com sucesso!&tipo=success');
        exit;
    }
} catch (PDOException $e) {
    header('Location: listar_pacientes.php?mensagem=Erro ao acessar banco de dados.&tipo=danger');
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Editar Paciente</h2>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($paciente['nome']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($paciente['cpf']); ?>" maxlength="14">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($paciente['telefone']); ?>" maxlength="15">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="listar_pacientes.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
