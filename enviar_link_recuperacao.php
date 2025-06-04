<?php
require_once 'conexao_cadastro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifica se o e-mail existe no banco
    $stmt = $connCadastro->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Gera token e data de expiração
        $token = bin2hex(random_bytes(32));
        $expira_em = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // DEBUG: Mostrar os valores gerados
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Token:</strong> $token</p>";
        echo "<p><strong>Expira em:</strong> $expira_em</p>";

        try {
            // Atualiza o usuário com token e expiração
            $stmt = $connCadastro->prepare("UPDATE usuarios 
                                            SET token_recuperacao = :token, expira_token = :expira 
                                            WHERE email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expira', $expira_em);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                // Gera o link de recuperação
                $link = "http://localhost:8080/sobras_inteligente_new/nova_senha.php?token=$token";

                // Mostra o link (simulando envio de e-mail)
                echo "<h3 style='color:green;'>✅ Um link de recuperação foi gerado!</h3>";
                echo "<p><strong>Link de recuperação:</strong> <a href='$link' target='_blank'>$link</a></p>";
                echo "<p><em>(Em ambiente de produção, este link seria enviado por e-mail)</em></p>";
            } else {
                echo "<p style='color:red;'>Erro ao atualizar o token no banco de dados.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro no banco de dados: " . $e->getMessage() . "</p>";
        }

    } else {
        echo "<p style='color:red;'>❌ E-mail não encontrado no sistema.</p>";
    }
}
?>
