<!DOCTYPE html>

<html lang="pt-BR">
  
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartKitchen</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style-index.css">

</head>


<!-- ajustar para dentro do body depois-->
<header>

    <img src="imagens/panela-quente.png" alt="Logo do aplicativo My Kitchen!" >
    <h1>Cozinha Criativa e Sustentável</h1>

</header>

<body>

    <nav>
        <a href="index.php">Início</a> |
        <a href="cadastro.html">Cadastro</a> |
        <a href="login.php">Login</a> |
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <hr>
    

    <main class="login-container">
    
        <h2>Entrar</h2>
        <input type="email" id="email" placeholder="Email" required />
        <input type="password" id="senha" placeholder="Senha" required />
        <button onclick="fazerLogin()">Entrar</button>
        <div id="erro" class="error"></div>

    </main>

    <script>
        
        function fazerLogin() {
            const email = document.getElementById("email").value;
            const senha = document.getElementById("senha").value;

        // Validação de login -> trocar isso por vinculo do BD com tabela de login/senha
            if (email === "teste@exemplo.com" && senha === "123456") {
                window.location.href = "home.html"; // redireciona para a tela inicial após login
            } else {
                document.getElementById("erro").innerText = "Email ou senha inválidos!";
            }
        }
  
    </script>

</body>

</html>