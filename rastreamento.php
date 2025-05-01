<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php'; // Garante que o usuário está logado
include 'includes/header.php';

$usuario_id = $_SESSION['usuario_id'];

// Buscar pedidos do usuário
$stmt = $db->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data DESC");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rastreamento de Pedidos</title>
    <style>
        body { background: #1C1C1C; color: #F5F5DC; font-family: Arial; }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; background: #2F2F2F; border-radius: 10px; }
        h2 { color: #D4AF37; }
        .pedido { background: #3D3D3D; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .produto { margin-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Meus Pedidos</h2>

        <?php if (empty($pedidos)): ?>
            <p>Você ainda não fez nenhum pedido. <a href="catalogo.php" style="color:#D4AF37;">Fazer um pedido agora</a>.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <strong>Pedido #<?= $pedido['id'] ?></strong><br>
                    Data: <?= date('d/m/Y H:i', strtotime($pedido['data'])) ?><br>
                    Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?><br>
                    Status: <strong><?= $pedido['status'] ?></strong>

                    <div class="produto">
                        <em>Produtos:</em><br>
                        <?php
                        $stmtItens = $db->prepare("
                            SELECT p.nome, i.quantidade, i.preco_unitario
                            FROM itens_pedido i
                            JOIN produtos p ON i.produto_id = p.id
                            WHERE i.pedido_id = ?
                        ");
                        $stmtItens->execute([$pedido['id']]);
                        $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($itens as $item):
                        ?>
                            - <?= $item['nome'] ?> (<?= $item['quantidade'] ?>x) - R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?><br>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>