<?php
session_start();
include 'includes/conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
        header("Location: home.php");
        exit();
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Online Bar</title>
    <style>
        body { font-family: Arial; background: #1C1C1C; color: #fff; }
        form { max-width: 300px; margin: 100px auto; background: #2F2F2F; padding: 20px; border-radius: 10px; }
        input, button { width: 100%; margin-top: 10px; padding: 10px; }
        .popup { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: flex; align-items: center; justify-content: center; }
    </style>
    <script>
        window.onload = function () {
            if (!localStorage.getItem("idade_confirmada")) {
                document.getElementById("popup").style.display = "flex";
            }
        }
        function confirmarIdade() {
            localStorage.setItem("idade_confirmada", "true");
            document.getElementById("popup").style.display = "none";
        }
    </script>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div id="popup" class="popup">
    <div style="background:#fff; color:#000; padding:20px; border-radius:10px;">
        <p>Este site é exclusivo para maiores de 18 anos.</p>
        <button onclick="confirmarIdade()">Sou maior de 18</button>
    </div>
</div>

<form method="POST">
    <h2>Login</h2>
    <?php if ($erro): ?><p style="color: red;"><?= $erro ?></p><?php endif; ?>
    <input type="email" name="email" placeholder="E-mail" required />
    <input type="password" name="senha" placeholder="Senha" required />
    <button type="submit">Entrar</button>
    <p style="margin-top:10px;"><a href="cadastro.php" style="color:#D4AF37;">Criar conta</a></p>
</form>

<?php include 'includes/footer.php'; ?>
</body>
</html>