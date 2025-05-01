<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header style="background:#5D001E; color:#F5F5DC; padding: 15px; display:flex; justify-content: space-between; align-items: center;">
    <div>
        <a href="home.php" style="color:#F5F5DC; text-decoration:none; font-size: 24px; font-weight:bold;">🍷 Online Bar</a>
    </div>
    <nav>
        <a href="catalogo.php" style="color:#D4AF37; margin: 0 10px;">Catálogo</a>
        <a href="carrinho.php" style="color:#D4AF37; margin: 0 10px;">Carrinho</a>
        <a href="usuario.php" style="color:#D4AF37; margin: 0 10px;">Minha Conta</a>
        <a href="logout.php" style="color:#FFA15E; margin-left: 20px;">Sair</a>
    </nav>
    <div style="font-size:14px;">👋 Olá, <?= $_SESSION['nome'] ?? 'Visitante' ?></div>
</header>