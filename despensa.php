<?php
session_start(); // Sempre a primeira coisa antes de qualquer saída

require_once 'conexao_cadastro.php'; // Conexão com o banco
// require_once 'navbar.php';  // Inclui navbar e chama ícone flutuante (que pode conter HTML)

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

$nome = $_SESSION['usuario']['nome'] ?? 'Usuário';
$foto = $_SESSION['usuario']['foto'] ?? 'https://cdn.vectorstock.com/i/500p/53/42/user-member-avatar-face-profile-icon-vector-22965342.jpg';
$id = $_SESSION['usuario']['id'];


// Busca os ingredientes da despensa do usuário logado
$sql = "SELECT eu.id_estoque, i.nome_ingrediente, eu.quantidade, i.unidade_medida_ingrediente, eu.data_validade
        FROM estoque_usuario eu
        JOIN ingrediente i ON eu.id_ingrediente = i.id_ingrediente
        WHERE eu.id_usuario = ?";

$stmt = $connCadastro->prepare($sql);
$stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$itens_despensa = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SmartKitchen - Despensa</title>
  <style>

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: url('imagens/despensa-de-alimentos.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
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

    button {
      background-color: #4caf50;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin: 5px;
    }

    button:hover {
      background-color: #388e3c;
    }

    main {
      background: rgba(0, 0, 0, 0.6);
      margin-top: 20px;
      padding: 20px;
      border-radius: 15px;
      max-width: 900px;
      width: 90%;
      box-sizing: border-box;
      color: #fff;
      max-height: 1200px;
      overflow-y: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #222;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 10px;
      text-align: center;
      border-bottom: 1px solid #444;
    }

    th {
      background-color: #4caf50;
      color: #fff;
    }

    tbody tr:hover {
      background-color: rgba(76, 175, 80, 0.3);
    }

    .btn-container {
      display: flex;
      justify-content: center;
      margin-top: 15px;
    }

    .checkbox {
      transform: scale(1.3);
    }

    .edit-btn {
      background-color: #2196f3;
    }

    .delete-btn {
      background-color: #f44336;
    }

    .edit-btn:hover {
      background-color: #1976d2;
    }

    .delete-btn:hover {
      background-color: #d32f2f;
    }

    .used {
      text-decoration: line-through;
      opacity: 0.6;
    }

    /* Estilo para a caixinha de legenda */
    #legenda-unidade {
      max-width: 900px;
      width: 90%;
      margin: 15px auto 30px auto;
      padding: 12px 20px;
      background-color: rgba(255, 255, 255, 0.9);
      color: #222;
      border-radius: 10px;
      font-size: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      font-weight: 600;
      line-height: 1.4;
    }

    #legenda-unidade strong {
      color: #4caf50;
    }

    /* Modal Styles */
    #modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
    }

    #modalContent {
      background-color: #222;
      padding: 20px 30px;
      border-radius: 12px;
      width: 320px;
      color: white;
      box-sizing: border-box;
      font-weight: 600;
    }

    #modalContent label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
    }

    #modalContent input {
      width: 100%;
      padding: 8px;
      border-radius: 8px;
      border: none;
      margin-bottom: 16px;
      font-size: 16px;
      box-sizing: border-box;
      font-weight: 600;
    }

    #modalContent .btn-row {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    #modalContent .btn-row button {
      flex: 1;
      padding: 10px 0;
      font-weight: 700;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    #btnSalvar {
      background-color: #4caf50;
      color: white;
    }

    #btnCancelar {
      background-color: #888;
      color: white;
    }

    #btnSalvar:hover {
      background-color: #388e3c;
    }

    #btnCancelar:hover {
      background-color: #666;
    }

    /* CSS do Botão de Gerar Receita */
    .gerar-receita-btn {
      background-color: #4caf50;
      border: none;
      padding: 15px 30px;
      font-size: 25px;
      font-weight: bold;
      border-radius: 10px;
      color: white;
      cursor: pointer;
      margin-top: 20px;
    }

    .gerar-receita-btn:hover {
      background-color: #388e3c;
      transition: background-color 0.3s ease;
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

      <button onclick="window.location.href='home.php'">Voltar</button>
  
    </div>

    <div class="nav-right">
      <button onclick="window.location.href='livro_de_receitas.php'">Ir para Livro de Receitas</button>
    </div>

  </nav>

  <main>
    <form action="receitas.php" method="POST" onsubmit="return validarSelecao()">
      
      <h2>Despensa</h2>
      
      <table>
        <thead>
          <tr>
            <th>✓</th>
            <th>Ingrediente</th>
            <th>Quantidade</th>
            <th>Unidade</th>
            <th>Validade</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody id="tabela-despensa">

          <?php foreach ($itens_despensa as $index => $item): ?>
            <tr>
              
              <td>
                <input type="checkbox" class="checkbox" name="ingredientes[]" value="<?= htmlspecialchars($item['nome_ingrediente']) ?>" />
              </td>

              <td><?= htmlspecialchars($item['nome_ingrediente']) ?></td>
              <td><?= htmlspecialchars($item['quantidade']) ?></td>
              <td><?= htmlspecialchars($item['unidade_medida_ingrediente']) ?></td>
              <td><?= date('d/m/Y', strtotime($item['data_validade'])) ?></td>
              
              <td>
                <button type="button" class="edit-btn" disabled>Editar</button>
                <button type="button" class="delete-btn" disabled>Excluir</button>
              </td>

            </tr>
          <?php endforeach; ?>

        </tbody>

      </table>
      
      <div class="btn-container">
        <button type="button" onclick="abrirModal()">Adicionar Novo Ingrediente</button>
      </div>
    
      <!-- Botão de Gerar Receita -->
      <div class="btn-container">
        <input type="submit" value="Gerar Receita" class="gerar-receita-btn">
      </div>

    </form>

  </main>

  <!-- Caixinha de legenda da Unidade, abaixo do main
  <div id="legenda-unidade">
    <strong>Unidade:</strong> Kg = Quilograma, L = Litros, Un = Unidades. Você pode digitar manualmente no campo unidade ao adicionar ou editar um ingrediente.
  </div> -->

  <!-- Modal para adicionar/editar item -->
  <div id="modal">
    <div id="modalContent">
      <form id="formItem">
        <label for="nomeInput">Nome do ingrediente:</label>
        <input type="text" id="nomeInput" autocomplete="off" required />

        <label for="quantidadeInput">Quantidade:</label>
        <input type="number" id="quantidadeInput" min="0.01" step="0.01" autocomplete="off" required />

        <label for="unidadeInput">Unidade (ex: kg, g, L, un):</label>
        <input type="text" id="unidadeInput" autocomplete="off" required />

        <label for="validadeInput">Data de validade:</label>
        <input type="text" id="validadeInput" maxlength="10" placeholder="DD/MM/AAAA" autocomplete="off" required />

        <div class="btn-row">
          <button type="button" id="btnCancelar" onclick="fecharModal()">Cancelar</button>
          <button type="submit" id="btnSalvar">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <script>

    document.addEventListener('DOMContentLoaded', listarItens);

    const tbody = document.getElementById('tabela-despensa');
    const modal = document.getElementById('modal');
    const formItem = document.getElementById('formItem');

    const nomeInput = document.getElementById('nomeInput');
    const quantidadeInput = document.getElementById('quantidadeInput');
    const unidadeInput = document.getElementById('unidadeInput');
    const validadeInput = document.getElementById('validadeInput');

    let itemEditando = null;

    function listarItens() {
      fetch('despensa_acao.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'acao=listar'
      })
      .then(res => res.json())
      .then(data => {
        tbody.innerHTML = '';
        
        if (data.sucesso && Array.isArray(data.itens)) {
          data.itens.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td><input type="checkbox" class="checkbox" name="ingredientes[]" value="${item.nome_ingrediente}" /></td>
              <td>${item.nome_ingrediente}</td>
              <td>${item.quantidade}</td>
              <td>${item.unidade_medida_ingrediente}</td>
              <td>${formatarData(item.data_validade)}</td>
              <td>
                <button type="button" class="edit-btn" onclick="abrirModal(${item.id_estoque}, '${item.nome_ingrediente}', ${item.quantidade}, '${item.unidade_medida_ingrediente}', '${item.data_validade}')">Editar</button>
                <button type="button" class="delete-btn" onclick="excluirItem(${item.id_estoque})">Excluir</button>
              </td>
            `;
            tbody.appendChild(tr);
          });
        } else {
          console.error("Erro ao carregar os itens da despensa:", data);
        }

      });
    }

    function abrirModal(id = null, nome = '', quantidade = '', unidade = '', validade = '') {
      itemEditando = id;
      nomeInput.value = nome;
      quantidadeInput.value = quantidade;
      unidadeInput.value = unidade;
      validadeInput.value = formatarData(validade, true); // Para editar, coloca no formato DD/MM/AAAA
      modal.style.display = 'flex';
    }

    function fecharModal() {
      modal.style.display = 'none';
      formItem.reset();
      itemEditando = null;
    }

    formItem.onsubmit = function (e) {
      e.preventDefault();

      const nome = nomeInput.value.trim();
      const quantidade = quantidadeInput.value;
      const unidade = unidadeInput.value.trim();
      const validade = validadeInput.value;
      const partesData = validade.split('/');
      const validadeConvertida = `${partesData[2]}-${partesData[1]}-${partesData[0]}`;

      const formData = new URLSearchParams();
      formData.append('nome', nome);
      formData.append('quantidade', quantidade);
      formData.append('unidade', unidade);
      formData.append('validade', validadeConvertida);

      if (itemEditando) {
        formData.append('acao', 'editar');
        formData.append('id_estoque', itemEditando);
      } else {
        formData.append('acao', 'adicionar');
      }

      console.log("Enviando dados para o PHP:", formData.toString()); // LOG 1

      fetch('despensa_acao.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: formData.toString()
      })
      .then(res => res.text()) // temporariamente .text() para debug
      .then(response => {
        console.log("Resposta recebida:", response); // LOG 2
        fecharModal();
        listarItens();
      })
      .catch(err => console.error("Erro na requisição:", err)); // LOG 3
    };

    function excluirItem(id) {
      if (!confirm("Tem certeza que deseja excluir este item?")) return;

      fetch('despensa_acao.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `acao=excluir&id_estoque=${id}`
      })
      .then(res => res.text())
      .then(() => listarItens());
    }

    function formatarData(data, paraInput = false) {
      const d = new Date(data);
      if (isNaN(d)) return data;

      if (paraInput) {
        const [ano, mes, dia] = data.split('-');
        return `${dia}/${mes}/${ano}`;
      }

      const dia = String(d.getDate()).padStart(2, '0');
      const mes = String(d.getMonth() + 1).padStart(2, '0');
      const ano = d.getFullYear();
      return `${dia}/${mes}/${ano}`;
    }

    // Fecha modal ao clicar fora
    window.onclick = function(e) {
      if (e.target == modal) fecharModal();
    };

  </script>


</body>
</html>
