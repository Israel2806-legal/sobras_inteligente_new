<?php
require_once 'conexao_cadastro.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Buscar foto do usuário para apagar arquivo
    $stmt = $connCadastro->prepare("SELECT foto FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && !empty($usuario['foto'])) {
        $foto_path = __DIR__ . '/uploads/' . $usuario['foto'];
        if (file_exists($foto_path)) {
            unlink($foto_path);
        }
    }

    // Deletar usuário
    $stmt = $connCadastro->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Redirecionar para a lista de usuários
header("Location: lista_usuarios.php");
exit;
