<?php include 'cabecalho.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Saída de Medicamento</h2>

                    <form method="POST" action="processa_saida.php">
                        <div class="mb-3">
                            <label class="form-label">Medicamento</label>
                            <input type="text" name="medicamento" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lote</label>
                            <input type="text" name="lote" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Paciente (opcional)</label>
                            <input type="text" name="paciente" class="form-control">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Registrar Saída</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
