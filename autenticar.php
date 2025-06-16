<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user["senha"])) {
            $_SESSION["usuario_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["tipo"] = $user["tipo"];

            if ($user["tipo"] === "admin") {
                header("Location: painel_admin.php");
            } else {
                header("Location: painel_cliente.php");
            }
            exit();
        }
    }

    echo "Email ou senha incorretos.";
}
?>