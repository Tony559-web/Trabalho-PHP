<?php
// Certifique-se de que a requisição é um GET com um ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listar_alugueis.php?delete_error=true"); // Redireciona com erro se o ID for inválido
    exit();
}

$aluguel_id = $_GET['id'];

$host = "localhost";
$user = "root";
$senha = "Anthony31.";
$banco = "loja_seguros";

$conn = new mysqli($host, $user, $senha, $banco);
if ($conn->connect_error) {
    // Em caso de falha na conexão, redireciona com erro
    header("Location: listar_alugueis.php?delete_error=true");
    exit();
}

// Prepara e executa a query de exclusão
// Usar prepared statements para evitar SQL Injection
$stmt = $conn->prepare("DELETE FROM alugueis WHERE id = ?");
if ($stmt === false) {
    // Erro na preparação da query
    $conn->close();
    header("Location: listar_alugueis.php?delete_error=true");
    exit();
}

$stmt->bind_param("i", $aluguel_id); // 'i' indica que o parâmetro é um inteiro

if ($stmt->execute()) {
    // Redireciona com sucesso após a exclusão
    header("Location: listar_alugueis.php?delete_success=true");
} else {
    // Redireciona com erro se a exclusão falhar
    header("Location: listar_alugueis.php?delete_error=true");
}

$stmt->close();
$conn->close();
exit();
?>
