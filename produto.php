<?php
include 'includes/db.php';
session_start();

$id_produto = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];
$quantidade = 1;

$sql = "INSERT INTO carrinho (id_usuario, id_produto, quantidade) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->execute([$id_usuario, $id_produto, $quantidade]);
?>