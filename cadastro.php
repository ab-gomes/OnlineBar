<!-- cadastro.php -->
<?php include 'includes/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Online Bar</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
    <h2>Cadastro de Usuário</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"] ?? '';
        $email = $_POST["email"] ?? '';
        $senha = $_POST["senha"] ?? '';
        $idade = $_POST["idade"] ?? 0;

        if ($nome && $email && $senha) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // segurança

            try {
                $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, idade) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nome, $email, $senha_hash, $idade]);
                echo "<p style='color:green;'>Cadastro realizado com sucesso!</p>";
            } catch (PDOException $e) {
                echo "<p style='color:red;'>Erro: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Preencha todos os campos obrigatórios!</p>";
        }
    }
    ?>

    <form method="post" action="">
        <label>Nome: <input type="text" name="nome" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Senha: <input type="password" name="senha" required></label><br><br>
        <label>Idade: <input type="number" name="idade"></label><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <?php include 'includes/footer.php'; ?>
</body>
</html>