<?php

require_once 'navbar.php';/*Chama o icone flutuante*/

$ingredientes = $_POST['ingredientes'] ?? [];

function gerarReceitaComIA($ingredientes) {
    $apiKey ='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'; // 🔑 Chave da OpenAI
    
    $prompt = "Com base nos itens selecionados, crie uma receita nutritiva e criativa. Os itens que estão disponíveis são: " . implode(", ", $ingredientes) . ". A receita deve conter: 1) Título, 2) Lista de ingredientes com medidas genéricas, 3) Modo de preparo em etapas numeradas, 4) Tempo estimado de preparo, 5) Nível de dificuldade: use uma escala de 0 a 10, sendo 10 um altíssimo nível de dificuldade.";

    $dados = [
        "model" => "gpt-3.5-turbo",
        "messages" => [
            ["role" => "user", "content" => $prompt]
        ]
    ];

    $curl = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ],
        CURLOPT_POSTFIELDS => json_encode($dados)
    ]);

    $resposta = curl_exec($curl);
    curl_close($curl);

    $resultado = json_decode($resposta, true);
    return $resultado['choices'][0]['message']['content'] ?? "Erro ao gerar receita.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Receita com IA</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('imagens/livro-de-receitas.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    nav {
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 10px 20px;
      background: rgba(0, 0, 0, 0.5);
    }
    button {
      background-color: #4caf50;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      color: white;
      font-weight: 600;
      cursor: pointer;
    }
    main {
      background: rgba(0, 0, 0, 0.6);
      padding: 20px;
      margin-top: 20px;
      border-radius: 15px;
      max-width: 800px;
      width: 90%;
      box-sizing: border-box;
    }
    pre {
      white-space: pre-wrap;
      font-family: inherit;
      line-height: 1.5em;
    }
  </style>
</head>
<body>

  <nav>
    <div><button onclick="window.location.href='despensa.php'">Voltar para Despensa</button></div>
    <div><button onclick="window.location.href='livro_de_receitas.php'">Livro de Receitas</button></div>
  </nav>

  <main>

      <h2>Receita Gerada com IA</h2>

    <?php if (count($ingredientes) > 0): 
      $conteudo_receita = gerarReceitaComIA($ingredientes);
    ?>

    <p><strong>Ingredientes selecionados:</strong> <?php echo implode(", ", $ingredientes); ?></p>
    
    <form id="formSalvarReceita">
      <textarea id="campoReceita" style="width:100%; height:300px; padding:10px; font-family:inherit; border-radius:10px;"><?php echo htmlspecialchars($conteudo_receita); ?></textarea>
      <div style="margin-top:20px; display:flex; justify-content:space-between;">
        <button type="button" onclick="window.location.href='despensa.php'">Voltar</button>
        <button type="submit">Salvar Receita</button>
      </div>
    </form>

    <script>
      document.getElementById('formSalvarReceita').addEventListener('submit', async function(e) {
        e.preventDefault();

        const texto = document.getElementById('campoReceita').value;

        // Extrai campos do texto da receita
        const linhas = texto.split('\n').map(l => l.trim()).filter(l => l.length > 0);

        const nome = linhas[0] || "Receita Sem Nome";

        const tempo = texto.match(/Tempo estimado.*?:\s*(.+)/i)?.[1]?.trim() || '';
        const dificuldade = texto.match(/dificuldade.*?:\s*(.+)/i)?.[1]?.trim() || '';

        // Captura o modo de preparo a partir da linha que contém "Modo de preparo" até o fim
        let modo_preparo = '';
        const idx = linhas.findIndex(l => /modo de preparo/i.test(l));
        if (idx !== -1) {
          modo_preparo = linhas.slice(idx + 1).join('\n');
        }

        const descricao = linhas.slice(1, 5).join(' ').slice(0, 500); // linhas 2 a 5 como resumo

        const dados = { nome, tempo, dificuldade, modo_preparo, descricao };

        const resposta = await fetch('salvar_receita.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(dados)
        });

        const resultado = await resposta.json();

        if (resultado.sucesso) {
          alert('Receita salva com sucesso!');
          window.location.href = 'livro_de_receitas.php';
        } else {
          alert('Erro ao salvar a receita: ' + (resultado.erro || 'Erro desconhecido'));
        }
      });
    </script>

  <?php else: ?>
    <p>Nenhum ingrediente selecionado. <a href="despensa.php">Voltar</a></p>
  <?php endif; ?>

  </main>

</body>
</html>
