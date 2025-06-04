

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cozinha Criativa e Sustentável</title>
  <link rel="stylesheet" href="css/style-home.css">
</head>
<body>

  <nav>
    <!-- Meu Perfil -->
    <div class="perfil-container">
      <a href="meu_perfil.php">
        <div class="navbar">
          <?php include 'navbar.php'; ?>
        </div>
      </a>
    </div>

    <!-- Botão Cadastrar -->
    <div class="nav-right">
      <a href="index.php">Sair</a>
    </div>

    <!-- Ícone menu -->
    <div class="hamburger" onclick="toggleMenu()">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>

    <!-- Menu Mobile -->
    <div class="mobile-menu" id="mobileMenu">
      <!-- <a href="cadastro.html">Cadastrar</a> -->
    </div>

  </nav>

  <div class="background-image"></div>

  <header>
    <h1>Cozinha Criativa e Sustentável</h1>
  </header>

  <main>
    
    <div class="opcoes-container">
      
      <a href="despensa.php" class="opcao">
        <img src="https://p2.trrsf.com/image/fget/cf/774/0/images.terra.com/2020/08/07/1308330286-no-mercado-existe-inumeros-itens-que-podem-auxiliar-na-organizacao-da-sua-despensa-de-cozinha-fonte-pinterest.jpg" alt="Despensa" />
        Despensa
      </a>
      
      <a href="livro_de_receitas.php" class="opcao">
        <img src="https://blog.clubedeautores.com.br/wp-content/uploads/2019/12/cookbook-746005_1920-750x410.jpg" alt="Livro de Receitas" />
        Livro de Receitas
      </a>
    
    </div>
  
  </main>

  <script>
    function toggleMenu() {
      const menu = document.getElementById("mobileMenu");
      menu.classList.toggle("active");
    }
  </script>

</body>
</html>

