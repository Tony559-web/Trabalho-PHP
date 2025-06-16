<?php
$host = "localhost";
$user = "root";
$senha = "Anthony31.";
$banco = "loja_seguros";

$conn = new mysqli($host, $user, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Mensagem de sucesso ou erro (se houver)
$message = '';
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    $message = '<div style="color: green; text-align: center; margin-bottom: 10px; font-weight: bold;">Aluguel excluído com sucesso!</div>';
} elseif (isset($_GET['delete_error']) && $_GET['delete_error'] == 'true') {
    $message = '<div style="color: red; text-align: center; margin-bottom: 10px; font-weight: bold;">Erro ao excluir aluguel.</div>';
}

$sql = "
    SELECT a.id, u.email AS cliente, a.data_inicio, a.data_fim, a.valor AS valor_aluguel,
           c.modelo AS modelo_carro, a.descricao_carro
    FROM alugueis a
    LEFT JOIN usuarios u ON a.usuario_id = u.id
    LEFT JOIN carros c ON a.carro_id = c.id
    ORDER BY a.data_inicio DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Aluguéis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .topo h2 {
            margin: 0;
            color: #333;
        }
        .topo .botoes button {
            margin-left: 10px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            background-color: #007bff; /* Um tom de azul */
            color: white; /* Cor do texto branco */
            border: 1px solid #007bff; /* Borda da mesma cor */
            border-radius: 5px; /* Bordas arredondadas como na imagem */
            transition: background-color 0.3s ease;
        }
        .topo .botoes button:hover {
            background-color: #0056b3; /* Um azul mais escuro no hover */
            border-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn-excluir {
            background-color: #dc3545; /* Vermelho para exclusão */
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.3s ease;
        }
        .btn-excluir:hover {
            background-color: #c82333;
        }

        /* Estilos do Modal de Confirmação */
        .modal {
            display: none; /* Escondido por padrão */
            position: fixed; /* Fixo na tela */
            z-index: 1; /* Acima de tudo */
            left: 0;
            top: 0;
            width: 100%; /* Largura total */
            height: 100%; /* Altura total */
            overflow: auto; /* Habilitar rolagem se necessário */
            background-color: rgba(0,0,0,0.4); /* Fundo semi-transparente */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            animation-name: animatetop;
            animation-duration: 0.4s
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .modal-buttons .confirm-btn {
            background-color: #dc3545; /* Vermelho para confirmar exclusão */
            color: white;
        }
        .modal-buttons .confirm-btn:hover {
            background-color: #c82333;
        }
        .modal-buttons .cancel-btn {
            background-color: #6c757d; /* Cinza para cancelar */
            color: white;
        }
        .modal-buttons .cancel-btn:hover {
            background-color: #5a6268;
        }
        /* Animação do Modal */
        @keyframes animatetop {
            from {top: -300px; opacity: 0}
            to {top: 0; opacity: 1}
        }
    </style>
</head>
<body>

<div class="container">
    <div class="topo">
        <h2>Lista de Aluguéis</h2>
        <div class="botoes">
            <button class="btn btn-primary" onclick="window.location.href='painel_cliente.php'">Novo Aluguel</button>
            <button class="btn btn-primary" onclick="window.location.href='logout.php'">Sair</button>
        </div>
    </div>

    <?= $message ?>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Exclusão</th> <!-- Trocado de 'ID' para 'Exclusão' -->
                <th>Carro</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Aluguel</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $carro_exibido = $row['modelo_carro'] ?? $row['descricao_carro'] ?? 'Não informado';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td>
                            <button class="btn-excluir" onclick="showConfirmationModal(<?= $row['id'] ?>)">Excluir</button>
                        </td>
                        <td><?= htmlspecialchars($carro_exibido) ?></td>
                        <td><?= htmlspecialchars($row['data_inicio']) ?></td>
                        <td><?= htmlspecialchars($row['data_fim']) ?></td>
                        <td>R$ <?= number_format($row['valor_aluguel'], 2, ',', '.') ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>Nenhum aluguel encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal de Confirmação -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <p>Confirma a exclusão deste aluguel?</p>
        <div class="modal-buttons">
            <button class="confirm-btn" id="confirmDeleteButton">OK</button>
            <button class="cancel-btn" onclick="hideConfirmationModal()">Cancelar</button>
        </div>
    </div>
</div>

<script>
    let aluguelIdToDelete = null; // Variável para armazenar o ID do aluguel a ser excluído

    function showConfirmationModal(id) {
        aluguelIdToDelete = id;
        document.getElementById('confirmationModal').style.display = 'flex'; // Usar flex para centralizar
    }

    function hideConfirmationModal() {
        document.getElementById('confirmationModal').style.display = 'none';
        aluguelIdToDelete = null; // Limpa o ID
    }

    document.getElementById('confirmDeleteButton').onclick = function() {
        if (aluguelIdToDelete !== null) {
            // Redireciona para o script de exclusão com o ID do aluguel
            window.location.href = 'excluir_aluguel.php?id=' + aluguelIdToDelete;
        }
        hideConfirmationModal(); // Esconde o modal após a ação
    };
</script>

</body>
</html>

<?php
$conn->close();
?>
