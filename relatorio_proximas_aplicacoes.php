<?php
include 'cabecalho.php';

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

$paciente_id = $_GET['paciente_id'] ?? '';
$medicamento_id = $_GET['medicamento_id'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Listar pacientes e medicamentos para os filtros
    $pacientes = $pdo->query("SELECT id, nome FROM pacientes WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
    $medicamentos = $pdo->query("SELECT id, nome FROM medicamentos WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

    // Buscar próximas aplicações com filtros
    $sql = "
        SELECT p.nome AS paciente, m.nome AS medicamento, m.lote, a.quantidade, a.data_aplicacao, a.data_proxima_aplicacao, a.data_sugerida_compra
        FROM aplicacoes a
        JOIN pacientes p ON a.paciente_id = p.id
        JOIN medicamentos m ON a.medicamento_id = m.id
        WHERE a.data_proxima_aplicacao IS NOT NULL
    ";

    $params = [];
    if (!empty($paciente_id)) {
        $sql .= " AND a.paciente_id = ?";
        $params[] = $paciente_id;
    }
    if (!empty($medicamento_id)) {
        $sql .= " AND a.medicamento_id = ?";
        $params[] = $medicamento_id;
    }

    $sql .= " ORDER BY a.data_proxima_aplicacao ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Relatório de Próximas Aplicações</h2>

                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label">Paciente</label>
                            <select name="paciente_id" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($pacientes as $pac): ?>
                                    <option value="<?= $pac['id']; ?>" <?= $paciente_id == $pac['id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($pac['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Medicamento</label>
                            <select name="medicamento_id" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($medicamentos as $med): ?>
                                    <option value="<?= $med['id']; ?>" <?= $medicamento_id == $med['id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($med['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-primary">
                            <tr>
                                <th>Paciente</th>
                                <th>Medicamento</th>
                                <th>Lote</th>
                                <th>Quantidade</th>
                                <th>Data da Aplicação</th>
                                <th>Próxima Aplicação</th>
                                <th>Sugerida Compra</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha['paciente']); ?></td>
                                    <td><?= htmlspecialchars($linha['medicamento']); ?></td>
                                    <td><?= htmlspecialchars($linha['lote']); ?></td>
                                    <td><?= $linha['quantidade']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($linha['data_aplicacao'])); ?></td>
                                    <td><?= date('d/m/Y', strtotime($linha['data_proxima_aplicacao'])); ?></td>
                                    <td><?= date('d/m/Y', strtotime($linha['data_sugerida_compra'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-3">
                        <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
