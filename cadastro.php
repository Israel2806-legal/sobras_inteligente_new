<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style-cadastro.css" />
</head>
<body>

    <!-- Mensagens de erro e sucesso do cadastro -->
    



    <!-- Fundo com imagem -->
    <div class="background-image"></div>

    <!-- Botão de login -->
    <div class="top-bar">
        <a href="index.php" class="login-button">Voltar</a>
    </div>

    <!-- Container do formulário -->
    <div class="form-container">
        <h1>Crie sua conta</h1>

        <?php

            session_start();

            if (isset($_SESSION['erro'])) {
                echo "<div class='mensagem erro'>{$_SESSION['erro']}</div>";
                unset($_SESSION['erro']);
            }

            if (isset($_SESSION['sucesso'])) {
                echo "<div class='mensagem sucesso'>{$_SESSION['sucesso']}</div>";
                unset($_SESSION['sucesso']);
            }
        
        ?>


        <form action="cadastrar.php" method="POST" enctype="multipart/form-data">

            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" required />

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required />

            <label for="data_de_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_de_nascimento" name="data_de_nascimento" required />

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required />

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required />

            <label for="confirmar_senha">Confirme sua senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required />

            <label for="foto">Foto de perfil:</label>
            <input type="file" id="foto" name="foto" accept="image/*" />

            <button type="submit" class="submit-button">Cadastrar</button>

        </form>

        <div class="login-link">
            <span>Já possui uma conta?</span>
            <a href="index.php" class="login-text-button">Entrar</a>
        </div>
    </div>

</body>
</html>
