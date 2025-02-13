<?php include 'cabecalho.php'; ?>

<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM pacientes ORDER BY nome");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Listagem de Pacientes</h2>

                    <?php if (isset($_GET['mensagem'])): ?>
                        <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['mensagem']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($pacientes as $paciente): ?>
                                <tr class="<?= $paciente['ativo'] ? '' : 'table-secondary'; ?>">
                                    <td><?= $paciente['id']; ?></td>
                                    <td><?= htmlspecialchars($paciente['nome']); ?></td>
                                    <td><?= htmlspecialchars($paciente['cpf']); ?></td>
                                    <td><?= htmlspecialchars($paciente['telefone']); ?></td>
                                    <td><?= $paciente['ativo'] ? 'Ativo' : 'Inativo'; ?></td>
                                    <td>
                                        <a href="editar_paciente.php?id=<?= $paciente['id']; ?>" class="btn btn-sm btn-warning">Editar</a>

                                        <?php if ($paciente['ativo']): ?>
                                            <a href="alterar_status_paciente.php?id=<?= $paciente['id']; ?>&status=0" class="btn btn-sm btn-secondary">Inativar</a>
                                        <?php else: ?>
                                            <a href="alterar_status_paciente.php?id=<?= $paciente['id']; ?>&status=1" class="btn btn-sm btn-success">Ativar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
