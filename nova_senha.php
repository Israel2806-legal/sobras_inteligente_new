<?php
require_once 'conexao_cadastro.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $connCadastro->prepare("SELECT * FROM usuarios WHERE token_recuperacao = :token AND expira_token > NOW()");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Exibe o formulário para redefinir a senha
        ?>
        <h2>Redefinir Senha</h2>
        <form method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            Nova Senha:<br><input type="password" name="nova_senha" required><br><br>
            <button type="submit">Atualizar Senha</button>
        </form>
        <?php
    } else {
        echo "<p style='color:red;'>Token inválido ou expirado.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token']) && isset($_POST['nova_senha'])) {
    $token = $_POST['token'];
    $novaSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $stmt = $connCadastro->prepare("UPDATE usuarios SET senha = :senha, token_recuperacao = NULL, expira_token = NULL WHERE token_recuperacao = :token");
    $stmt->bindParam(':senha', $novaSenha);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

     echo "<p>Senha redefinida com sucesso! <a href='index.php'>Voltar ao login</a></p>";
     

}
?>
