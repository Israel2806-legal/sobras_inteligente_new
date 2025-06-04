<?php
session_start();
require_once 'conexao_cadastro.php', 'navbar.php';

// Consulta usuários
$stmt = $connCadastro->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        img {
            width: 60px;
            border-radius: 8px;
            object-fit: cover;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        div.actions {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Usuários Cadastrados</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td>
                <?php if (!empty($usuario['foto'])): ?>
                    <img src="uploads/<?= htmlspecialchars($usuario['foto']) ?>" alt="Foto de <?= htmlspecialchars($usuario['nome']) ?>">
                <?php else: ?>
                    Sem foto
                <?php endif; ?>
            </td>
            <td>
                <a href="cadastro_usuario.php?id=<?= $usuario['id'] ?>">Editar</a> |
                <a href="excluir_usuario.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="actions">
    <a href="cadastro_usuario.php">Novo Cadastro</a> |
    <a href="logout.php">Sair</a>
</div>

</body>
</html>
