<?php
$ingredientes = $_POST['ingredientes'];
$acao = $_POST['acao'];

if ($acao === 'restrito') {
    $mensagem = "Crie uma receita detalhada usando apenas os seguintes ingredientes e mais nenhum outro: $ingredientes.";
} else {
    $mensagem = "Crie uma receita detalhada usando os seguintes ingredientes: $ingredientes. Pode incluir outros ingredientes se necessário.";
}

$chave_api = "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";


$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $chave_api"
    ],
    CURLOPT_POSTFIELDS => json_encode([
        "model" => "gpt-3.5-turbo",
        "messages" => [
            ["role" => "user", "content" => $mensagem]
        ],
        "temperature" => 0.7
    ]),
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    $resposta = "Erro ao conectar com a OpenAI: " . curl_error($curl);
} else {
    $resultado = json_decode($response, true);
    $resposta = $resultado['choices'][0]['message']['content'] ?? "Não foi possível gerar a receita.";
}
curl_close($curl);

// Salvar no banco
include("conexao.php");

$tipo = $acao === 'restrito' ? 'Só ingredientes informados' : 'Com complementares';

$stmt = $conn->prepare("INSERT INTO receitas (ingredientes, tipo, receita) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $ingredientes, $tipo, $resposta);
$stmt->execute();
$stmt->close();
$conn->close();

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Receita Gerada</title>
    <style>
        body { background-color: AntiqueWhite; font-family: Arial; padding: 20px; }
        .box { background: white; padding: 20px; border-radius: 15px; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: green; }
        .sucesso { text-align: center; color: darkgreen; font-weight: bold; margin-bottom: 10px; }
        pre { white-space: pre-wrap; font-size: 16px; }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            margin: 10px 5px;
            cursor: pointer;
        }
        .voltar-btn { background-color: LightGreen; color: black; }
    </style>
</head>
<body>
    <div class='box'>
        <h1>Receita Criada</h1>
        <div class='sucesso'>✅ Receita salva com sucesso!</div>
        <pre>$resposta</pre>
        <div style='text-align: center;'>
            <button class='voltar-btn' onclick=\"window.location.href='teste.php'\">⬅ Voltar</button>
            <button onclick=\"window.location.href='receitas.php'\">📜 Ver receitas salvas</button>
        </div>
    </div>
</body>
</html>";
?>