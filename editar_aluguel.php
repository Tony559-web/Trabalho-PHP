<?php
$conn = new mysqli("localhost", "root", "", "aluguel_carros");
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $_POST['cliente'];
    $modelo = $_POST['modelo_carro'];
    $inicio = $_POST['data_inicio'];
    $fim = $_POST['data_fim'];
    $valor = $_POST['valor'];
    $stmt = $conn->prepare("UPDATE alugueis SET cliente=?, modelo_carro=?, data_inicio=?, data_fim=?, valor=? WHERE id=?");
    $stmt->bind_param("ssssdi", $cliente, $modelo, $inicio, $fim, $valor, $id);
    $stmt->execute();
    echo "<script>alert('Aluguel atualizado com sucesso!'); window.location='listar_alugueis.php';</script>";
    exit;
}
$res = $conn->query("SELECT * FROM alugueis WHERE id=$id");
$row = $res->fetch_assoc();
?>
<form method="post">
    <h2>Editar Aluguel</h2>
    <input name="cliente" value="<?= $row['cliente'] ?>" required><br>
    <input name="modelo_carro" value="<?= $row['modelo_carro'] ?>" required><br>
    <input type="date" name="data_inicio" value="<?= $row['data_inicio'] ?>" required><br>
    <input type="date" name="data_fim" value="<?= $row['data_fim'] ?>" required><br>
    <input type="number" step="0.01" name="valor" value="<?= $row['valor'] ?>" required><br>
    <button type="submit">Salvar</button>
</form>