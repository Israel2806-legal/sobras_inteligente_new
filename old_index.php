<?php
session_start();
$erro = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cozinha Criativa e Sustentável - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }
        form {
            background: #fff;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label, input, button, a {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input {
            padding: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .erro {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .links {
            text-align: center;
        }
    </style>
</head>
<body>

    <form method="post" action="login.php" autocomplete="off">
        <h2>Cozinha Criativa e Sustentável</h2>

        <?php if (!empty($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Digite seu email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

        <button type="submit">Entrar</button>

        <div class="links">
            <a href="cadastro_usuario.php">Primeiro Acesso</a> |
            <a href="recuperar_senha.html">Esqueci Minha Senha</a>
        </div>
    </form>

</body>
</html>
