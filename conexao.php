<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'sobras_inteligente_new'; // <--- altere para o nome real do seu banco de dados

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

// Verifica a conexão
if (!$conexao) {
    die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
}
?>


