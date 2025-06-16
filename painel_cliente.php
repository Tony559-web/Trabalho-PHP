<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["tipo"] !== "cliente") {
    header("Location: login.php");
    exit();
}

// Conexão com o banco
$conn = new mysqli("localhost", "root", "Anthony31.", "loja_seguros");

// Buscar clientes
$clientes = $conn->query("SELECT id, email FROM usuarios WHERE tipo = 'cliente'");

// Buscar carros disponíveis
$carros = $conn->query("SELECT id, modelo, marca, ano FROM carros WHERE disponivel = 1");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Cadastro de Aluguel</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Formulário -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <form class="user" action="salvar_aluguel.php" method="post">

                                        <!-- Cliente -->
                                        <div class="form-group">
                                            <label class="small">Cliente</label>
                                            <select name="cliente_id" class="form-control form-control-user" required>
                                                <option value="">Selecione um cliente</option>
                                                <?php while ($cliente = $clientes->fetch_assoc()): ?>
                                                    <option value="<?= $cliente['id'] ?>">
                                                        <?= htmlspecialchars($cliente['email']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <!-- Carro disponível -->
                                        <!-- Carro -->
                                        <div class="form-group">
                                            <label class="small">Carro</label>
                                                <?php if ($_SESSION["tipo"] === "cliente"): ?>
                                         <!-- Se for cliente, input de texto -->
                                            <input type="text" name="carro_nome" class="form-control form-control-user" placeholder="Digite o carro desejado" required>
                                            <?php else: ?>
                                        <!-- Se for admin, select com os carros disponíveis -->
                                            <select name="carro_id" class="form-control form-control-user" required>
                                                <option value="">Selecione um carro</option>
                                                <?php while ($carro = $carros->fetch_assoc()): ?>
                                                    <option value="<?= $carro['id'] ?>">
                                                        <?= htmlspecialchars("{$carro['modelo']} - {$carro['marca']} ({$carro['ano']})") ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                                 <?php endif; ?>
                                        </div>


                                        <!-- Data de Início -->
                                        <div class="form-group">
                                            <label class="small">Data de Início</label>
                                            <input type="date" class="form-control form-control-user" name="data_inicio" required>
                                        </div>

                                        <!-- Data de Devolução -->
                                        <div class="form-group">
                                            <label class="small">Data de Devolução</label>
                                            <input type="date" class="form-control form-control-user" name="data_fim" required>
                                        </div>

                                        <!-- Valor do Aluguel -->
                                        <div class="form-group">
                                            <label class="small">Aluguel</label>
                                            <input type="number" step="0.01" class="form-control form-control-user"
                                                placeholder="Valor do Aluguel (R$)" name="valor" required>
                                                 <small class="form-text text-muted mt-2">
                                                 <strong>Valores estimados:</strong><br>
                                                     Carros econômicos (hatchs, sedãs compactos): <strong>R$ 50 por dia</strong>.<br>
                                                     Carros médios (sedãs, SUVs compactos): <strong>R$ 100 por dia</strong>.<br>
                                                     Carros maiores (SUVs, veículos espaçosos): <strong>R$ 200 por dia</strong>.
                                                 </small>
                                        </div>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Salvar Aluguel">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
                                                    