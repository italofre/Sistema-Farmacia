<?php
include 'cabecalho.php';

if ($_SESSION['grupo'] !== 'admin') {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar esta página.</div>";
    exit;
}

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT u.id, u.nome, u.email, u.ativo, g.nome AS grupo
            FROM usuarios u
            JOIN grupos g ON u.grupo_id = g.id
            ORDER BY u.nome";

    $usuarios = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<h2>Gerenciar Usuários</h2>

<a href="cadastro_usuario.php" class="btn btn-success mb-3">Cadastrar Novo Usuário</a>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Grupo</th>
        <th>Situação</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['nome']); ?></td>
            <td><?= htmlspecialchars($usuario['email']); ?></td>
            <td><?= htmlspecialchars($usuario['grupo']); ?></td>
            <td><?= $usuario['ativo'] ? 'Ativo' : 'Inativo'; ?></td>
            <td>
                <a href="editar_usuario.php?id=<?= $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>

                <?php if ($usuario['ativo']): ?>
                    <a href="ativar_desativar_usuario.php?id=<?= $usuario['id']; ?>&acao=desativar" class="btn btn-secondary btn-sm" onclick="return confirm('Deseja realmente desativar este usuário?');">Desativar</a>
                <?php else: ?>
                    <a href="ativar_desativar_usuario.php?id=<?= $usuario['id']; ?>&acao=ativar" class="btn btn-success btn-sm">Ativar</a>
                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
