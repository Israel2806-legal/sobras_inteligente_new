<?php
session_start();
require_once 'conexao_cadastro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $foto = $_FILES['foto'] ?? null;

    // Buscar o usuário atual
    $stmt = $connCadastro->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "Usuário não encontrado!";
        exit;
    }

    // Atualização da foto (se foi enviada)
    $novoNomeArquivo = $usuario['foto']; // manter a foto atual se nenhuma nova for enviada

    if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $novoNomeArquivo = uniqid() . '.' . $extensao; // ex: 647fe1f0d34a2.jpg
        move_uploaded_file($foto['tmp_name'], 'uploads/' . $novoNomeArquivo);
    }

    // Atualizar o banco de dados
    $stmt = $connCadastro->prepare("UPDATE usuarios SET nome = ?, senha = ?, foto = ? WHERE email = ?");
    $stmt->execute([$nome, $senha, $novoNomeArquivo, $email]);

    echo "Perfil atualizado com sucesso!";
    header("Location: meu_perfil.html?email=" . urlencode($email) . "&atualizado=true");
    exit;
} else {
    echo "Requisição inválida.";
}
?>
