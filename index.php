<?php 
session_start();
?>


<!DOCTYPE html> 
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Cozinha Criativa e Sustentável</title>
  <link rel="stylesheet" href="css/style-index.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: none;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url("imagens/fundo-cozinha.png") no-repeat center center fixed;
      background-size: cover;
      filter: brightness(0.6);
      z-index: -1;
    }

    .main-container {
      width: 100%;
      max-width: 480px;
      padding: 0 15px;
    }

    .frase-img {
      display: flex;
      flex-wrap: nowrap; /* Não quebra linha */
      justify-content: center;
      gap: 4px;
      margin: 15px 0;
      max-width: 480px;
      margin-left: auto;
      margin-right: auto;
      /* Aumenta o tamanho da letra para ficar mais encorpado */
      max-height: 60px; /* controle visual do tamanho */
    }

    .linha1 {
      margin-bottom: 10px;
    }

    .linha2 {
      margin-top: 10px;
    }

    .letra {
      flex: 0 0 auto;
      max-width: 40px;
      aspect-ratio: 1/1;
      display: flex;
      justify-content: center;
      align-items: center;
      filter: drop-shadow(1px 1px 1px rgba(0,0,0,0.4)); /* sombra para dar mais corpo */
      transform: scale(1.1); /* deixa maior */
      transition: transform 0.3s ease;
    }

    .letra img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .letra:hover {
      transform: scale(1.2);
    }

    .espaco {
      visibility: hidden;
      max-width: 15px; /* espaço menor */
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      text-align: center;
      margin: 15px 0;
      width: 100%;
    }

    .login-container h1 {
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #444;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      outline: none;
    }

    .button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .button:hover {
      background-color: #45a049;
    }

    p {
      margin-top: 15px;
      color: #555;
    }

    a {
      color: #007BFF;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Linha 1: Cozinha Criativa -->
  <div class="frase-img linha1">
    <div class="letra"><img src="imagens/letra_c.png" alt="C"></div>
    <div class="letra"><img src="imagens/letra_o.png" alt="O"></div>
    <div class="letra"><img src="imagens/letra_z.png" alt="Z"></div>
    <div class="letra"><img src="imagens/letra_i.png" alt="I"></div>
    <div class="letra"><img src="imagens/letra_n.png" alt="N"></div>
    <div class="letra"><img src="imagens/letra_h.png" alt="H"></div>
    <div class="letra"><img src="imagens/letra_a.png" alt="A"></div>
    <div class="letra espaco"><img src="imagens/letra_a.png" alt=" "></div> <!-- espaço -->
    <div class="letra"><img src="imagens/letra_c.png" alt="C"></div>
    <div class="letra"><img src="imagens/letra_r.png" alt="R"></div>
    <div class="letra"><img src="imagens/letra_i.png" alt="I"></div>
    <div class="letra"><img src="imagens/letra_a.png" alt="A"></div>
    <div class="letra"><img src="imagens/letra_t.png" alt="T"></div>
    <div class="letra"><img src="imagens/letra_i.png" alt="I"></div>
    <div class="letra"><img src="imagens/letra_v.png" alt="V"></div>
    <div class="letra"><img src="imagens/letra_a.png" alt="A"></div>
  </div>

  <!-- Linha 2: Sustentável -->
  <div class="frase-img linha2">
    <div class="letra"><img src="imagens/letra_s.png" alt="S"></div>
    <div class="letra"><img src="imagens/letra_u.png" alt="U"></div>
    <div class="letra"><img src="imagens/letra_s.png" alt="S"></div>
    <div class="letra"><img src="imagens/letra_t.png" alt="T"></div>
    <div class="letra"><img src="imagens/letra_e.png" alt="E"></div>
    <div class="letra"><img src="imagens/letra_n.png" alt="N"></div>
    <div class="letra"><img src="imagens/letra_t.png" alt="T"></div>
    <div class="letra"><img src="imagens/letra_a.png" alt="A"></div>
    <div class="letra"><img src="imagens/letra_v.png" alt="V"></div>
    <div class="letra"><img src="imagens/letra_e.png" alt="E"></div>
    <div class="letra"><img src="imagens/letra_l.png" alt="L"></div>
  </div>

  <div class="main-container">
    <div class="login-container">
      <h1>Login</h1>
      
      <form action="login.php" method="POST">
        
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required />
        </div>
        
        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" name="senha" placeholder="Digite sua senha" required />
        </div>
        
        <button type="submit" class="button">Entrar</button>
      
      </form>
      <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>

    <?php
      if (isset($_SESSION['login_error'])) {
          echo "<p style='color:red; text-align:center; font-weight:bold'>" . $_SESSION['login_error'] . "</p>";
          unset($_SESSION['login_error']);
      }
    ?>


  </div>
</body>
</html>