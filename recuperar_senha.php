<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - Sobras Inteligentes</title>
</head>
<body>

    <nav>
        <a href="index.php">Início</a> |
        <a href="cadastro.html">Cadastro</a> |
        <a href="login.php">Login</a> |
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <hr>
    
    <h2>Recuperar Senha</h2>
    <form action="enviar_link_recuperacao.php" method="POST">
        <label>Informe seu e-mail cadastrado:</label><br>
        <input type="email" name="email" required><br><br>
        <button type="submit">Enviar link de recuperação</button>
    </form>
    <p><a href="index.php">← Voltar para login</a></p>
</body>
</html>