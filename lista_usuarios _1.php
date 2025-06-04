<?php

require_once 'navbar.php';/*Chama o icone flutuante*/

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Lista de Usuários</title>
<style>
  table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
  }
  th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
  }
  img {
    width: 60px;
    border-radius: 8px;
    object-fit: cover;
  }
  a {
    text-decoration: none;
    color: #007bff;
  }
  a:hover {
    text-decoration: underline;
  }
  div.actions {
    text-align: center;
    margin: 20px;
  }
</style>
</head>
<body>
<h2 style="text-align: center;">Usuários Cadastrados</h2>

<table id="tabela-usuarios">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Foto</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr><td colspan="5">Carregando usuários...</td></tr>
  </tbody>
</table>

<div class="actions">
  <a href="cadastro_usuario.php">Novo Cadastro</a> |
  <a href="logout.php">Sair</a>
</div>

<script>
fetch('http://localhost:8080/sobras_inteligente_new/lista_usuarios_json.php')
  .then(response => {
    if (!response.ok) throw new Error('Erro na resposta da API');
    return response.json();
  })
  .then(data => {
    const tbody = document.querySelector('#tabela-usuarios tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(data) || data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5">Nenhum usuário encontrado</td></tr>';
      return;
    }

    data.forEach(usuario => {
      const tr = document.createElement('tr');

      tr.innerHTML = `
        <td>${usuario.id}</td>
        <td>${usuario.nome}</td>
        <td>${usuario.email}</td>
        <td>${usuario.foto ? `<img src="uploads/${usuario.foto}" alt="Foto de ${usuario.nome}">` : 'Sem foto'}</td>
        <td>
          <a href="cadastro_usuario.php?id=${usuario.id}">Editar</a> |
          <a href="excluir_usuario.php?id=${usuario.id}" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
        </td>
      `;
      tbody.appendChild(tr);
    });
  })
  .catch(error => {
    console.error('Erro ao carregar lista:', error);
    const tbody = document.querySelector('#tabela-usuarios tbody');
    tbody.innerHTML = '<tr><td colspan="5">Erro ao carregar lista</td></tr>';
  });
</script>

</body>
</html>
