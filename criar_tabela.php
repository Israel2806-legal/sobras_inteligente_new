<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sobras_inteligente_new";
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
)";

if ($conexao->query($sql) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conexao->error;
}

$conexao->close();
?>
