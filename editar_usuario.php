<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sobras_inteligente_new"; // altere aqui
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id";
    if ($conexao->query($sql) === TRUE) {
        echo "Usuário atualizado com sucesso! <a href='listar_usuarios.php'>Voltar</a>";
    } else {
        echo "Erro: " . $conexao->error;
    }
} else {
    $sql = "SELECT * FROM usuarios WHERE id=$id";
    $resultado = $conexao->query($sql);
    $usuario = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h2>Editar Usuário</h2>
    <form method="post">
        Nome: <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>"><br><br>
        Email: <input type="email" name="email" value="<?php echo $usuario['email']; ?>"><br><br>
        <input type="submit" value="Salvar">
        <a href="listar_usuarios.php">Cancelar</a>
    </form>
</body>
</html>
