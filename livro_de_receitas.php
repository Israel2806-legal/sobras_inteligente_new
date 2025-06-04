<?php
session_start();
require_once 'conexao_cadastro.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

$nome = $_SESSION['usuario']['nome'] ?? 'Usuário';
$foto = $_SESSION['usuario']['foto'] ?? 'https://cdn.vectorstock.com/i/500p/53/42/user-member-avatar-face-profile-icon-vector-22965342.jpg';
$id = $_SESSION['usuario']['id'];

// Consulta receitas favoritas do usuário
$sql = "
SELECT r.*
FROM usuario_receita_favorito urf
JOIN receita r ON urf.id_receita = r.id_receita
WHERE urf.id_usuario = ?
ORDER BY r.id_receita DESC
";
$stmt = $connCadastro->prepare($sql);
$stmt->execute([$id_usuario]);
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Livro de Receitas</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('imagens/livro-de-receitas.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 20px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 2rem;
    }

    nav {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background: rgba(0, 0, 0, 0.5);
      box-sizing: border-box;
    }

    .nav-left, .nav-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    nav button {
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    nav button:hover {
      background-color: #388e3c;
    }

    main {
      flex: 1;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.6);
      margin: 20px auto 40px;
      width: 90%;
      max-width: 900px;
      border-radius: 15px;
      box-sizing: border-box;
      overflow-y: auto;
      max-height: 80vh;
    }

    #toggleReceitasBtn {
      background-color: #2196f3;
      margin-bottom: 15px;
      width: 100%;
      font-size: 1.1rem;
    }
    #toggleReceitasBtn:hover {
      background-color: #0b7dda;
    }

    .receita {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      position: relative;
    }

    .receita h2 {
      margin-top: 0;
      color: #ffc107;
    }

    .receita ul {
      padding-left: 20px;
    }

    .receita img {
      max-width: 100%;
      max-height: 200px;
      margin-top: 10px;
      border-radius: 10px;
      object-fit: cover;
    }

    .receita-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .receita-buttons button {
      background-color: #ff5722;
      border: none;
      color: white;
      padding: 6px 12px;
      margin-left: 10px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .receita-buttons button.edit-btn {
      background-color: #03a9f4;
    }

    .receita-buttons button:hover {
      opacity: 0.8;
    }
  </style>
</head>
<body>

  <nav>

    <div class="nav-left">
    <form action="meu_perfil.php" method="POST" style="display: flex; align-items: center; gap: 10px;">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <button type="submit" style="display: flex; align-items: center; background-color: #4caf50; padding: 5px 10px; border-radius: 10px; border: none; cursor: pointer;">
        <img src="<?= htmlspecialchars($foto) ?>" alt="Perfil de <?= htmlspecialchars($nome) ?>" style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; margin-right: 8px;">
        <span style="color: white; font-weight: bold;"><?= htmlspecialchars($nome) ?></span>
      </button>
    </form>

    <button onclick="window.location.href='despensa.php'">Voltar à Despensa</button>
  </div>

  <div class="nav-right">
    <button onclick="window.location.href='home.php'">Voltar à Home</button>
  </div>

  </nav>

  <header>
    <h1>Livro de Receitas</h1>
  </header>

  <main>
    
    <h2>Receitas Favoritas Salvas</h2>

    <?php if (count($receitas) === 0): ?>
      <p>Nenhuma receita salva ainda.</p>
    <?php else: ?>
      <?php foreach ($receitas as $receita): ?>
        <article class="receita">
          <h2><?= htmlspecialchars($receita['nome_receita']) ?></h2>
          
          <?php if (!empty($receita['imagem_receita'])): ?>
            <img src="uploads/<?= htmlspecialchars($receita['imagem_receita']) ?>" alt="Imagem da Receita">
          <?php endif; ?>

          <?php if (!empty($receita['descricao_receita'])): ?>
            <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($receita['descricao_receita'])) ?></p>
          <?php endif; ?>

          <p><strong>Tempo de Preparo:</strong> <?= htmlspecialchars($receita['tempo_prep_receita']) ?: 'Não informado' ?></p>
          <p><strong>Dificuldade:</strong> <?= htmlspecialchars($receita['dificuldade_receita']) ?: 'Não informado' ?></p>
          <p><strong>Modo de Preparo:</strong><br><?= nl2br(htmlspecialchars($receita['modo_preparo'])) ?></p>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>

  </main>

</body>
</html>
