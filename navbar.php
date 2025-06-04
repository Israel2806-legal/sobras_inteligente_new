<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION['usuario']['id'] ?? null;
$nome = $_SESSION['usuario']['nome'] ?? 'Usuário';
$foto = $_SESSION['usuario']['foto'] ?? 'https://cdn.vectorstock.com/i/500p/53/42/user-member-avatar-face-profile-icon-vector-22965342.jpg';
?>

<style>
.botao-flutuante-container {
  position: relative;
  top: 10px;
  left: 10px;
  background-color: #4caf50;
  border-radius: 8px;
  padding: 5px 10px;
  display: flex;
  align-items: center;
  gap: 10px;
  z-index: 5;
}

.botao-flutuante-container img {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  border: 2px solid #fafafa; /* Borda branca */
}

.botao-flutuante-container span {
  color: #fff;
  font-weight: bold;
  font-size: 14px;
}
</style>

<form action='meu_perfil.php' method='POST'>
  <input type='hidden' name='id' value='<?php echo htmlspecialchars($id); ?>'>
  
  <button class='botao-flutuante-container' type="submit">
    <img src='<?php echo htmlspecialchars($foto); ?>' alt='Perfil de <?php echo htmlspecialchars($nome); ?>'>
    <span><?php echo htmlspecialchars($nome); ?></span>
  </button>

</form>