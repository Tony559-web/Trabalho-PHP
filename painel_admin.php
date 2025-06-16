<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>
<h2>Painel do Administrador</h2>
<p>Bem-vindo, <?= htmlspecialchars($_SESSION["email"]) ?>!</p>
<a href="logout.php">Sair</a>