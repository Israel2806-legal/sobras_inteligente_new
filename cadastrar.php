<?php

session_start();

require_once 'conexao_cadastro.php'; // Conexão com o banco de dados

// 1. Recebendo os dados do formulário da página cadastro.php
// Não precisa de id_usuario, ele é auto_increment
$nome     = $_POST['nome'] ?? '';
$cpf      = $_POST['cpf'] ?? '';
$email    = $_POST['email'] ?? '';
$senha    = $_POST['senha'] ?? '';
$confirma = $_POST['confirmar_senha'] ?? '';
$dtNasc   = $_POST['data_de_nascimento'] ?? '';
$foto     = $_FILES['foto'] ?? null;

// 2. Validação básica
if ($senha !== $confirma) {
    $_SESSION['erro'] = 'As senhas não coincidem.';
    header('Location: cadastro.php');
    exit;
}

// 3. Verificando duplicidade de e-mail ou CPF
$stmt = $connCadastro->prepare("SELECT COUNT(*) FROM usuario WHERE email_usuario = :email OR cpf_usuario = :cpf");
$stmt->execute([
    ':email' => $email,
    ':cpf' => $cpf
]);
if ($stmt->fetchColumn() > 0) {
    $_SESSION['erro'] = 'E-mail ou CPF já cadastrados.';
    header('Location: cadastro.php');
    exit;
}

// 4. (Para avaliarmos depois) Gerar hash da senha, por enquanto seguimos com a senha simples
// $senhaFinal = $senha; // ou: password_hash($senha, PASSWORD_DEFAULT);

// 5. Upload da imagem, se enviada
$fotoPath = null;
if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid('perfil_', true) . '.' . $ext;
    $destino = 'imagens/uploads/' . $novoNome;

    if (move_uploaded_file($foto['tmp_name'], $destino)) {
        $fotoPath = $destino;
    }
}

// 6. Inserindo no banco de dados
$stmt = $connCadastro->prepare("
    INSERT INTO usuario (
        nome_usuario, cpf_usuario, email_usuario, senha_hash,
        dt_nascimento_usuario, foto_usuario
    ) VALUES (
        :nome, :cpf, :email, :senha, :nascimento, :foto
    )
");

$stmt->execute([
    ':nome'       => $nome,
    ':cpf'        => $cpf,
    ':email'      => $email,
    ':senha'      => $senha,
    ':nascimento' => $dtNasc,
    ':foto'       => $fotoPath
]);

// 7. Redirecionar para login com mensagem
$_SESSION['sucesso'] = 'Cadastro realizado com sucesso! Faça login.';
header('Location: index.php');
exit;

?>