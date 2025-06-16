<?php
$host = "localhost";
$usuario = "root";
$senha = "Anthony31.";
$banco = "loja_seguros";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>