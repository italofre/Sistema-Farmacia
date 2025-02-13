<?php
include 'cabecalho.php';

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SELECT m.id, m.tipo, m.quantidade, m.lote, m.paciente, m.data_movimentacao, med.nome AS medicamento_nome
        FROM movimentacoes m
        JOIN medicamentos med ON m.medicamento_id = med.id

        UNION ALL

        SELECT NULL AS id, 'saida' AS tipo, a.quantidade, med.lote, p.nome AS paciente, a.data_aplicacao AS data_movimentacao, med.nome AS medicamento_nome
        FROM aplicacoes a
        JOIN medicamentos med ON a.medicamento_id = med.id
        LEFT JOIN pacientes p ON a.paciente_id = p.id

        ORDER BY data_movimentacao DESC
    ";

    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<div class="container mt-5">
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

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Histórico de Movimentações</h2>

                    <div class="d-flex justify-content-start mb-3">
                        <a href="exportar_historico_csv.php" class="btn btn-success me-2">Exportar para CSV</a>
                        <a href="exportar_historico_pdf.php" class="btn btn-danger">Exportar para PDF</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-primary">
                            <tr>
                                <th>Tipo</th>
                                <th>Medicamento</th>
                                <th>Lote</th>
                                <th>Quantidade</th>
                                <th>Paciente</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($mov = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr class="<?= $mov['tipo'] === 'saida' ? 'table-danger' : 'table-success'; ?>">
                                    <td><?= ucfirst($mov['tipo']); ?></td>
                                    <td><?= htmlspecialchars($mov['medicamento_nome']); ?></td>
                                    <td><?= htmlspecialchars($mov['lote']); ?></td>
                                    <td><?= $mov['quantidade']; ?></td>
                                    <td><?= htmlspecialchars($mov['paciente'] ?: '-'); ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($mov['data_movimentacao'])); ?></td>
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
