<?php include 'cabecalho.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Sistema de Controle de Estoque - Farmácia</h2>

    <?php if (isset($_GET['mensagem'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['mensagem']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <!-- Funcionalidades de Administração -->
        <?php if ($_SESSION['grupo'] === 'admin'): ?>
            <div class="col">
                <a href="cadastro_usuario.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Cadastro de Usuários</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="listar_usuarios.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Usuários</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="cadastro_paciente.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Cadastrar Paciente</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="listar_pacientes.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Pacientes</h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <!-- Funcionalidades Gerais -->
        <div class="col">
            <a href="cadastro_medicamento.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Cadastrar Medicamento</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="aplicacao_medicamento.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Registrar Aplicação</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="entrada_medicamento.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Registrar Entrada de Medicamentos</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="saida_medicamento.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Registrar Saída de Medicamentos</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="consulta_estoque.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Consultar Estoque</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="relatorio_proximas_aplicacoes.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Relatório de Próximas Aplicações</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="historico_movimentacoes.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Histórico de Movimentações</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="relatorio_vencidos.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center border-warning">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Medicamentos Vencidos</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="relatorio_estoque_baixo.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center border-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Medicamentos com Estoque Baixo</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
