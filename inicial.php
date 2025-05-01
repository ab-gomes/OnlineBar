<?php
include 'includes/auth.php';
include 'includes/conexao.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home - Online Bar</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Bem-vindo(a), <?= $_SESSION['nome'] ?>!</h1>
    <p>Você está logado como <?= $_SESSION['tipo_usuario'] ?>.</p>
    <a href="catalogo.php">Ver Catálogo</a>
<?php include 'includes/footer.php'; ?>
</body>