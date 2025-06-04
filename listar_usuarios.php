<?php
require_once 'conexao_cadastro.php';

$stmt = $connCadastro->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Usuários</h2>
<?php if (isset($_GET['mensagem']) && $_GET['mensagem'] == 'excluido'): ?>
    <p style="color: green;">Usuário excluído com sucesso!</p>
<?php endif; ?>

<a href="cadastro_usuario.php">Novo Usuário</a>
<table border="1">
    <tr>
        <th>ID</th><th>Nome</th><th>Email</th><th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?php echo $usuario['id']; ?></td>
        <td><?php echo $usuario['nome']; ?></td>
        <td><?php echo $usuario['email']; ?></td>
        <td>
            <a href="cadastro_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
            <a href="excluir_usuario.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>