<?php include 'cabecalho.php'; ?>

<?php if (isset($_GET['mensagem'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_GET['mensagem']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Cadastrar Medicamento</h2>

                    <form action="processa_cadastro.php" method="POST" id="formCadastroMedicamento">
                        <div class="mb-3">
                            <label class="form-label">Nome do Medicamento</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lote</label>
                            <input type="text" name="lote" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Validade</label>
                            <input type="date" name="validade" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data da Compra</label>
                            <input type="date" name="data_compra" class="form-control" max="<?= date('Y-m-d'); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="estoque" class="form-control" min="0" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="medicamento_especial" value="1" id="medicamentoEspecial">
                            <label class="form-check-label" for="medicamentoEspecial">
                                Medicamento Especial
                            </label>
                        </div>

                        <!-- Campo oculto para confirmar soma em caso de lote repetido -->
                        <input type="hidden" name="confirmar_soma" id="confirmar_soma" value="nao">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
