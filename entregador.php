<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Atualizar status do pedido, se enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'], $_POST['novo_status'])) {
    $pedido_id = $_POST['pedido_id'];
    $novo_status = $_POST['novo_status'];

    $stmt = $db->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->execute([$novo_status, $pedido_id]);
}

// Buscar pedidos com status Pendente ou Em andamento
$stmt = $db->query("SELECT * FROM pedidos WHERE status IN ('Pendente', 'Em andamento') ORDER BY data ASC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel do Entregador</title>
    <style>
        body { background: #1C1C1C; color: #F5F5DC; font-family: Arial; }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; background: #2F2F2F; border-radius: 10px; }
        h2 { color: #D4AF37; }
        .pedido { background: #3D3D3D; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .btn {
            margin-top: 10px;
            background: #D4AF37;
            color: #000;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        select {
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🚚 Painel do Entregador</h2>

        <?php if (empty($pedidos)): ?>
            <p>Nenhum pedido pendente ou em andamento no momento.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <strong>Pedido #<?= $pedido['id'] ?></strong><br>
                    Data: <?= date('d/m/Y H:i', strtotime($pedido['data'])) ?><br>
                    Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?><br>
                    Status atual: <strong><?= $pedido['status'] ?></strong><br><br>

                    <em>Produtos:</em><br>
                    <?php
                    $stmtItens = $db->prepare("
                        SELECT p.nome, i.quantidade
                        FROM itens_pedido i
                        JOIN produtos p ON i.produto_id = p.id
                        WHERE i.pedido_id = ?
                    ");
                    $stmtItens->execute([$pedido['id']]);
                    $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($itens as $item):
                    ?>
                        - <?= $item['nome'] ?> (<?= $item['quantidade'] ?>x)<br>
                    <?php endforeach; ?>

                    <form method="post">
                        <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                        <label for="status">Atualizar status:</label>
                        <select name="novo_status">
                            <option value="Em andamento" <?= $pedido['status'] == 'Em andamento' ? 'selected' : '' ?>>Em andamento</option>
                            <option value="Saiu para entrega">Saiu para entrega</option>
                            <option value="Entregue">Entregue</option>
                        </select>
                        <button class="btn" type="submit">Atualizar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>