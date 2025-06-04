<?php
session_start();

if (!isset($_SESSION['logado'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo à Cozinha Criativa e Sustentável!</h1>
    <p>Login realizado com sucesso!</p>
    <a href="logout.php">Sair</a>
</body>
</html>

