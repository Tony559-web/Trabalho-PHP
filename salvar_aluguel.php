<?php
session_start(); // necessário para acessar $_SESSION['tipo']

$host = "localhost";
$user = "root";
$senha = "Anthony31.";
$banco = "loja_seguros";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$cliente_id = $_POST['cliente_id'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$valor = $_POST['valor'];

// Se for cliente, o carro é digitado (texto). Se for admin, é o ID.
if ($_SESSION["tipo"] === "cliente") {
    $carro_nome = $_POST['carro_nome'];

    // Inserir como texto em outro campo da tabela (ex: `descricao_carro`) OU usar lógica própria
    $stmt = $conn->prepare("INSERT INTO alugueis (usuario_id, carro_id, data_inicio, data_fim, valor, descricao_carro) VALUES (?, NULL, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    $stmt->bind_param("issds", $cliente_id, $data_inicio, $data_fim, $valor, $carro_nome);

} else {
    $carro_id = $_POST['carro_id'];

    $stmt = $conn->prepare("INSERT INTO alugueis (usuario_id, carro_id, data_inicio, data_fim, valor) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    $stmt->bind_param("iissd", $cliente_id, $carro_id, $data_inicio, $data_fim, $valor);
}

if ($stmt->execute()) {
    echo "<script>alert('Aluguel salvo com sucesso!'); window.location.href='listar_alugueis.php';</script>";
} else {
    echo "Erro ao salvar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
