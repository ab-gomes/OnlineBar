<?php
include 'includes/auth.php'; // garante que o usuário está logado
include 'includes/conexao.php';
include 'includes/header.php';

// Buscar produtos do banco
$stmt = $conexao->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catálogo - Online Bar</title>
    <style>
        body { background-color: #1C1C1C; color: #F5F5DC; font-family: Arial; margin: 0; padding: 0; }
        .catalogo { display: flex; flex-wrap: wrap; padding: 20px; justify-content: center; }
        .produto {
            background: #2F2F2F;
            margin: 15px;
            padding: 15px;
            width: 220px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 8px #000;
        }
        .produto img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .produto h3 { margin: 10px 0 5px; color: #D4AF37; }
        .produto p { margin: 4px 0; font-size: 14px; }
        .btn {
            background: #D4AF37;
            color: #000;
            padding: 8px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        .btn:hover { background: #FFA15E; }
    </style>
</head>
<body>

<div class="catalogo">
    <?php foreach ($produtos as $produto): ?>
        <div class="produto">
            <img src="<?= $produto['imagem'] ?? 'imagens/default.jpg' ?>" alt="<?= $produto['nome'] ?>">
            <h3><?= $produto['nome'] ?></h3>
            <p>Tipo: <?= $produto['tipo'] ?></p>
            <p>Teor: <?= $produto['teor_alcoolico'] ?>%</p>
            <p><strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong></p>
            <form method="POST" action="carrinho.php">
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                <button type="submit" class="btn">Adicionar ao carrinho</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>