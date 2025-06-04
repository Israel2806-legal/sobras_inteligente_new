<?php
session_start();
$SESSION ['usuario']=[
  'id' => '',
  'nome' => '',
  'foto' => ''
  ];
require_once 'conexao_cadastro.php';

$usuario = ['id' => '', 'nome' => '', 'cpf' => '', 'email' => '', 'senha' => '', 'foto' => ''];

// Se estiver editando, busca o usuário no banco
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $connCadastro->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) {
        die("Usuário não encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica e prepara os dados
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    if ($senha !== $confirma_senha) {
        echo "⚠ As senhas não coincidem.";
        exit;
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Foto atual para manter se não enviar nova
    $foto_nome = $usuario['foto'];

    // Upload da foto, se houver nova
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

        if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $foto_nome = time() . '_' . preg_replace("/[^a-z0-9\.]/", "", basename($foto['name']));
            $foto_destino = 'uploads/' . $foto_nome;

            if (!move_uploaded_file($foto['tmp_name'], $foto_destino)) {
                echo 'Erro ao fazer upload da foto.';
                exit;
            }

            // Apaga a foto anterior se existir
            if (!empty($usuario['foto']) && file_exists('uploads/' . $usuario['foto'])) {
                unlink('uploads/' . $usuario['foto']);
            }
        } else {
            echo 'Formato de imagem inválido! Use jpg, jpeg, png ou gif.';
            exit;
        }
    }

    if (!empty($_POST['id'])) {
        // Atualiza usuário
        $stmt = $connCadastro->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, foto = :foto WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    } else {
        // Cadastra novo usuário
        $stmt = $connCadastro->prepare("INSERT INTO usuarios (nome, cpf, email, senha, foto) VALUES (:nome, :cpf, :email, :senha, :foto)");
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senhaCriptografada);
    $stmt->bindParam(':foto', $foto_nome);

    $stmt->execute();

    header("Location: lista_usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title><?php echo empty($usuario['id']) ? 'Cadastrar Usuário' : 'Editar Usuário'; ?></title>
</head>
<body>
    <h2><?php echo empty($usuario['id']) ? 'Cadastrar Usuário' : 'Editar Usuário'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">

        Nome:<br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>

        CPF:<br>
        <input type="text" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required><br><br>

        Email:<br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required minlength="6"><br><br>

        Confirmar Senha:<br>
        <input type="password" name="confirma_senha" required minlength="6"><br><br>

        Foto de Perfil:<br>
        <input type="file" name="foto" accept="image/*"><br>
        <?php if (!empty($usuario['foto'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($usuario['foto']); ?>" width="100" alt="Foto de Perfil"><br>
        <?php endif; ?><br>

        <button type="submit">Salvar</button>
    </form>

    <br>
    <a href="lista_usuarios.php">← Voltar para a lista</a>
</body>
</html>
