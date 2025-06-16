<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-container h2 {
            color: #5e2a84;
            margin-bottom: 30px;
        }
        .form-control {
            margin-bottom: 20px;
            padding-left: 40px;
        }
        .input-group-text {
            width: 40px;
            background-color: #e9ecef;
        }
        .btn-custom {
            background-color: #5e2a84;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #4a216a;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="autenticar.php">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-3"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
        </form>
    </div>
</body>
</html>
