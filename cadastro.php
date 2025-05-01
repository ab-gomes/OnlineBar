
<?php
include 'includes/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verificar se o CPF ou email já existem
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE cpf = ? OR email = ?");
    $stmt->execute([$cpf, $email]);
    if ($stmt->fetch()) {
        $mensagem = "Já existe um usuário com este CPF ou e-mail.";
    } else {
        // Inserir no banco
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $cpf, $email, $senha])) {
            $mensagem = "Cadastro realizado com sucesso! <a href='index.php'>Faça login</a>";
        } else {
            $mensagem = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Online Bar</title>
    <style>
        body { font-family: Arial; background: #1C1C1C; color: #fff; }
        form { max-width: 400px; margin: 80px auto; background: #2F2F2F; padding: 20px; border-radius: 10px; }
        input, button { width: 100%; margin-top: 10px; padding: 10px; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

<form method="POST">
    <h2>Cadastro</h2>
    <?php if ($mensagem): ?><p><?= $mensagem ?></p><?php endif; ?>
    <input type="text" name="nome" placeholder="Nome completo" required />
    <input type="text" name="cpf" placeholder="CPF (somente números)" pattern="\d{11}" required />
    <input type="email" name="email" placeholder="E-mail" required />
    <input type="password" name="senha" placeholder="Senha" required />
    <button type="submit">Cadastrar</button>
    <p style="margin-top:10px;"><a href="index.php" style="color:#D4AF37;">Já tenho uma conta</a></p>
</form>

<?php include 'includes/footer.php'; ?>
</body>
</html>