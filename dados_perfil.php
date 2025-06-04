<?php

include 'conexão.php';

    $nome = $_POST['user_name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $preferencias_usuario = $_POST['diet'];
    $restricoes_usuario = $_POST['restrictions'];

    $sql = "UPDATE usuario SET nome_usuario='$nome', email_usuario='$email', senha_hash='$senha', preferencias_usuario='$preferencias_usuario', restricoes_usuario='$restricoes_usuario' VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $senha, $preferencias_usuario, $restricoes_usuario);

        if ($stmt->execute()) {
            echo "Dados salvos com sucesso!";
        } else {
            echo "Erro: " . $stmt->error;
        }

    $stmt->close();
    $conn->close();

?>