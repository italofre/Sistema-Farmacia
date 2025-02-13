<?php
$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
    $sql = "SELECT * FROM medicamentos WHERE nome LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['%' . $busca . '%']);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

<?php include 'cabecalho.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Consulta de Estoque</h2>

                    <!-- Alerta de Mensagem -->
                    <?php if (isset($_GET['mensagem'])): ?>
                        <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['mensagem']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>

                        <script>
                            setTimeout(function () {
                                document.querySelector('.alert').remove();
                            }, 6000);
                        </script>
                    <?php endif; ?>

                    <!-- Campo de Pesquisa -->
                    <form method="GET" class="mb-3 d-flex">
                        <input type="text" class="form-control me-2" name="busca" placeholder="Buscar medicamento..." value="<?= htmlspecialchars($busca) ?>">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Lote</th>
                                <th>Validade</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $temRegistros = false;
                            while ($med = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $temRegistros = true;

                                // Classes para fundo condicional
                                $classeEstoque = ($med['estoque'] <= 5) ? 'table-danger' : '';
                                $classeValidade = (!empty($med['validade']) && strtotime($med['validade']) < time()) ? 'table-warning' : '';
                                $classeInativo = (!$med['ativo']) ? 'table-secondary' : '';
                                $classeLinha = $classeEstoque ?: $classeValidade ?: $classeInativo;

                                // Texto do status
                                $statusTexto = $med['ativo'] ? 'Ativo' : 'Inativo';
                                ?>
                                <tr class="<?= $classeLinha; ?>">
                                    <td><?= $med['id']; ?></td>
                                    <td><?= htmlspecialchars($med['nome']); ?></td>
                                    <td><?= htmlspecialchars($med['lote']); ?></td>
                                    <td><?= date('d/m/Y', strtotime($med['validade'])); ?></td>
                                    <td><?= $med['estoque']; ?></td>
                                    <td><?= $statusTexto; ?></td>
                                    <td>
                                        <a href="editar_medicamento.php?id=<?= $med['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="excluir_medicamento.php?id=<?= $med['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este medicamento?');">Excluir</a>

                                        <?php if ($med['ativo']): ?>
                                            <a href="alterar_status_medicamento.php?id=<?= $med['id']; ?>&status=0" class="btn btn-sm btn-secondary">Inativar</a>
                                        <?php else: ?>
                                            <a href="alterar_status_medicamento.php?id=<?= $med['id']; ?>&status=1" class="btn btn-sm btn-success">Ativar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if (!$temRegistros): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Nenhum medicamento encontrado.</td>
                                </tr>
                            <?php endif; ?>
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
