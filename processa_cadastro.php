<?php
session_start();

$host = 'localhost';
$db   = 'estoque_farmacia';
$user = 'farmacia_user';
$pass = 'senha_forte';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nome = $_POST['nome'];
    $lote = $_POST['lote'];
    $validade = $_POST['validade'];
    $estoque = $_POST['estoque'];
    $data_compra = !empty($_POST['data_compra']) ? $_POST['data_compra'] : null;
    $medicamento_especial = isset($_POST['medicamento_especial']) ? 1 : 0;
    $confirmar_soma = $_POST['confirmar_soma'] ?? 'nao';

    // Verifica se já existe o lote cadastrado
    $stmt = $pdo->prepare("SELECT id, estoque FROM medicamentos WHERE lote = ?");
    $stmt->execute([$lote]);
    $medicamento_existente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($medicamento_existente) {
        if ($confirmar_soma === 'sim') {
            $novo_estoque = $medicamento_existente['estoque'] + $estoque;
            $stmt = $pdo->prepare("UPDATE medicamentos SET estoque = ? WHERE id = ?");
            $stmt->execute([$novo_estoque, $medicamento_existente['id']]);

            header('Location: cadastro_medicamento.php?mensagem=Quantidade adicionada ao lote existente com sucesso!&tipo=success');
            exit;
        } else {
            echo "<script>
                    if (confirm('Lote já cadastrado. Deseja somar a quantidade ao lote existente?')) {
                        document.body.innerHTML += '<form method=\"POST\" action=\"processa_cadastro.php\" id=\"formConfirmar\">' +
                            '<input type=\"hidden\" name=\"nome\" value=\"$nome\">' +
                            '<input type=\"hidden\" name=\"lote\" value=\"$lote\">' +
                            '<input type=\"hidden\" name=\"validade\" value=\"$validade\">' +
                            '<input type=\"hidden\" name=\"estoque\" value=\"$estoque\">' +
                            '<input type=\"hidden\" name=\"data_compra\" value=\"$data_compra\">' +
                            '<input type=\"hidden\" name=\"medicamento_especial\" value=\"$medicamento_especial\">' +
                            '<input type=\"hidden\" name=\"confirmar_soma\" value=\"sim\">' +
                            '</form>';
                        document.getElementById('formConfirmar').submit();
                    } else {
                        window.location.href = 'cadastro_medicamento.php?mensagem=Lote duplicado. Cadastro cancelado.&tipo=danger';
                    }
                  </script>";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO medicamentos (nome, lote, validade, estoque, data_compra, medicamento_especial) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $lote, $validade, $estoque, $data_compra, $medicamento_especial]);

        header('Location: cadastro_medicamento.php?mensagem=Medicamento cadastrado com sucesso!&tipo=success');
        exit;
    }
} catch (PDOException $e) {
    header('Location: cadastro_medicamento.php?mensagem=Erro ao cadastrar medicamento!&tipo=danger');
    exit;
}
