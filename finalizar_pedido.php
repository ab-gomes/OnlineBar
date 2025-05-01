<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/header.php';

if (empty($_SESSION['carrinho'])) {
    echo "<p style='padding:20px;'>Seu carrinho está vazio!</p>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$carrinho = $_SESSION['carrinho'];

// Buscar os produtos do carrinho
$ids = implode(',', array_keys($carrinho));
$stmt = $db->query("SELECT * FROM produtos WHERE id IN ($ids)");
$produtosDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total do pedido
$total = 0;
foreach ($produtosDB as $produto) {
    $quantidade = $carrinho[$produto['id']];
    $total += $produto['preco'] * $quantidade;
}

// Criar pedido
$stmt = $db->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
$stmt->execute([$usuario_id, $total]);
$pedido_id = $db->lastInsertId();

// Inserir itens do pedido
$stmtItem = $db->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");

foreach ($produtosDB as $produto) {
    $quantidade = $carrinho[$produto['id']];
    $stmtItem->execute([$pedido_id, $produto['id'], $quantidade, $produto['preco']]);
}

// Limpar o carrinho
unset($_SESSION['carrinho']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pedido Finalizado</title>
    <style>
        body { background: #1C1C1C; color: #F5F5DC; font-family: Arial; text-align: center; padding: 40px; }
        .box { background: #2F2F2F; padding: 30px; border-radius: 10px; display: inline-block; }
        .btn-voltar {
            background: #D4AF37;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>✅ Pedido finalizado com sucesso!</h2>
        <p>Seu número de pedido é <strong>#<?= $pedido_id ?></strong></p>
        <p>Total: <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
        <p>Status: <strong>Pendente</strong></p>
        <a href="catalogo.php" class="btn-voltar">Voltar ao Catálogo</a>
    </div>
</body>
</html>