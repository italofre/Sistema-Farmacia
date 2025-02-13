<?php
include 'cabecalho.php';

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pacientes = $pdo->query("SELECT id, nome FROM pacientes WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
    $medicamentos = $pdo->query("SELECT id, nome, lote FROM medicamentos WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<?php if (isset($_GET['mensagem'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_GET['mensagem']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>

    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        }, 5000);
    </script>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Registrar Aplicação de Medicamento</h2>

                    <form action="processa_aplicacao.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Paciente</label>
                            <select name="paciente_id" class="form-select" required>
                                <option value="">Selecione</option>
                                <?php foreach ($pacientes as $paciente): ?>
                                    <option value="<?= $paciente['id']; ?>"><?= htmlspecialchars($paciente['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Medicamento</label>
                            <select name="medicamento_id" class="form-select" required>
                                <option value="">Selecione</option>
                                <?php foreach ($medicamentos as $medicamento): ?>
                                    <option value="<?= $medicamento['id']; ?>">
                                        <?= htmlspecialchars($medicamento['nome']) . ' - Lote: ' . htmlspecialchars($medicamento['lote']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data da Aplicação</label>
                            <input type="date" name="data_aplicacao" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Periodicidade (em dias)</label>
                            <input type="number" name="periodicidade" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade Aplicada</label>
                            <input type="number" name="quantidade" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
