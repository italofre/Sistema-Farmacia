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
                    <h2 class="mb-4 text-center">Cadastrar Usuário</h2>

                    <form method="POST" action="cadastro_usuario.php">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Grupo</label>
                            <select name="grupo_id" class="form-control" required>
                                <option value="1">Admin</option>
                                <option value="2">Assistente</option>
                                <option value="3">Consulta</option>
                            </select>
                        </div>

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
