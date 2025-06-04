<?php
session_start();

require_once 'conexao_cadastro.php';

$id_usuario = $_SESSION['usuario']['id'] ?? null;

if (!$id_usuario) {
    header("Location: index.php");
    exit;
}

// Buscar dados do usuário no banco
$stmt = $connCadastro->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
$stmt->bindParam(':id', $id_usuario);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Meu Perfil</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('imagens/fundo-sobras-inteligentes.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      max-width: 600px;
      width: 100%;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      position: relative;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
      color: #444;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px 12px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s ease;
    }

    input:focus,
    select:focus {
      outline: none;
      border-color: #4caf50;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #45a049;
    }

    #message-box {
      margin-top: 20px;
      text-align: center;
      font-weight: bold;
    }

    #profileImage {
      display: block;
      margin: 0 auto 20px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #4caf50;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    input[type="file"] {
      padding: 10px 0;
    }

    #btn-back {
      background-color: #ccc;
      color: #333;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1000;
      width: auto;
    }

    #btn-back:hover {
      background-color: #bbb;
    }

    #btn-despensa {
      background-color: #ccc;
      color: #333;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
      width: auto;
    }

    #btn-despensa:hover {
      background-color: #bbb;
    }

    #btn-excluir {
      margin-top: 20px;
      background-color: #e53935;
    }

    #btn-excluir:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>
  
  <button id="btn-back">← Voltar
    <a href="home.php"></a>
  </button>

  <button id="btn-despensa">Ir para Despensa
    <a href="despensa.php"></a>
  </button>

  <div class="container">
    <h2>Meu Perfil</h2>

    <!-- Imagem de perfil, a do banco ou icone padrão -->
    <img id="profileImage"
      src="<?php echo $usuario['foto_usuario'] ?? 'https://cdn.vectorstock.com/i/500p/53/42/user-member-avatar-face-profile-icon-vector-22965342.jpg'; ?>"
      alt="Foto de Perfil">

    <div class="form-group">
      <label for="profilePic">Alterar Foto de Perfil:</label>
      <input type="file" id="profilePic" accept="image/*" />
    </div>

    <form id="profile-form">
      <div class="form-group">
        <label for="username">Nome de usuário:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" />
      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" />
      </div>

      <div class="form-group">
        
        <label for="foodPref">Preferência Alimentar:</label>
        <select id="foodPref" name="foodPref">

          <?php
            $opcoesPref = ['Nenhuma', 'Vegetariano', 'Vegano', 'Sem Lactose', 'Sem Glúten', 'Low Protein', 'Low Carb'];
            foreach ($opcoesPref as $opcao) {
                $selected = ($usuario['preferencias_usuario'] == $opcao) ? 'selected' : '';
                echo "<option value='$opcao' $selected>$opcao</option>";
            }
          ?>

        </select>
      </div>

      <div class="form-group">
        <label for="restricoes">Restrições Alimentares:</label>
        <select id="restricoes" name="restricoes">
          
          <?php
            $opcoesRes = ['Nenhuma', 'Lactose', 'Glúten', 'Nozes', 'Amemdoim', 'Frutos-do-mar', 'Trigo', 'Soja', 'Ovo', 'Peixe'];
            foreach ($opcoesRes as $opcao) {
                $selected = ($usuario['restricoes_usuario'] == $opcao) ? 'selected' : '';
                echo "<option value='$opcao' $selected>$opcao</option>";
            }
          ?>

        </select>
      </div>

      <button type="submit">Salvar</button>
    </form>

    <button id="btn-excluir">Excluir Perfil</button>

    <div id="message-box"></div>
  </div>

  <script>
    
    /* Salvamento de arquivos local
    
    function saveProfile(data) {
      localStorage.setItem('meuPerfil', JSON.stringify(data));
    }

    function loadProfile() {
      const saved = localStorage.getItem('meuPerfil');
      if (saved) {
        return JSON.parse(saved);
      }
      return null;
    }

    function updateProfileImage(src) {
      const img = document.getElementById('profileImage');
      img.src = src;
    }

    */


    document.addEventListener('DOMContentLoaded', () => {

      /* Salvamento de arquivos local

      const profileData = loadProfile();
      if (profileData) {
        document.getElementById('username').value = profileData.username || '';
        document.getElementById('email').value = profileData.email || '';
        document.getElementById('foodPref').value = profileData.foodPref || 'nenhuma';
        document.getElementById('restricoes').value = profileData.restricoes || 'nenhuma';
        if (profileData.photo) {
          updateProfileImage(profileData.photo);
        }
      }

      document.getElementById('profilePic').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
          updateProfileImage(e.target.result);
          const currentData = loadProfile() || {};
          currentData.photo = e.target.result;
          saveProfile(currentData);
        };
        reader.readAsDataURL(file);
      });

      document.getElementById('profile-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const data = {
          username: document.getElementById('username').value.trim(),
          email: document.getElementById('email').value.trim(),
          foodPref: document.getElementById('foodPref').value,
          restricoes: document.getElementById('restricoes').value,
          photo: document.getElementById('profileImage').src
        };

        saveProfile(data);

        const msg = document.getElementById('message-box');
        msg.style.color = 'green';
        msg.textContent = 'Perfil salvo com sucesso!';
      });

      */

      // Ação do botão de ir para a despensa
      document.getElementById('btn-despensa').addEventListener('click', () => {
        window.location.href = 'despensa.php';
      });

      // Ação do botão de voltar para a Home
      document.getElementById('btn-back').addEventListener('click', () => {
        window.location.href = 'home.php';
      });

      // NÃO TESTEI AINDA
      document.getElementById('btn-excluir').addEventListener('click', () => {
        if (confirm('Tem certeza que deseja excluir seu perfil? Esta ação é irreversível.')) {
          window.location.href = 'excluir_usuario.php?id=<?php echo $usuario['id_usuario']; ?>';

        }
      });
    });
  </script>
</body>
</html>
