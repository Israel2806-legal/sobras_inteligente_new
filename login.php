<?php
session_start();
require_once 'conexao_cadastro.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email && $senha) {
    $stmt = $connCadastro->prepare("SELECT * FROM usuario WHERE email_usuario = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    //if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
    // Desativei o hash por enquanto devido a alguns problemas
    if ($usuario && $senha === $usuario['senha_hash']) {

        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nome' => $usuario['nome_usuario'],
            'foto' => $usuario['foto_usuario'] ?? null
            // verificar esse trecho pra ver se foto funciona
        ];

        header("Location: home.php");

        exit;

    } else {
        $_SESSION['login_error'] = "Email ou senha inválidos.";
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION['login_error'] = "Preencha todos os campos.";
    header("Location: index.php");
    exit;
}
