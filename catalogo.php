<?php include 'includes/conexao.php'; ?>
<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Bebidas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Nosso Catálogo de Bebidas</h2>
    <div class="catalogo">
        <?php
        // Consulta básica
        $sql = "SELECT * FROM bebidas LIMIT 10"; // ajusta conforme sua tabela
        $stmt = $db->query($sql);
        $bebidas = $stmt->fetchAll();

        foreach ($bebidas as $b) {
            echo "
            <div class='produto'>
                <img src='assets/bebidas/{$b['imagem']}' alt='{$b['nome']}'>
                <h3>{$b['nome']}</h3>
                <p>{$b['descricao']}</p>
                <span class='preco'>R$ {$b['preco']}</span>
                <button>Adicionar ao carrinho</button>
            </div>";
        }
        ?>
    </div>

<?php include 'includes/footer.php'; ?>
</body>
</html>