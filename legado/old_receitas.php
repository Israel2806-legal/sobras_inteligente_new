<?php
include("conexao.php");

$result = $conn->query("SELECT * FROM receitas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Receitas Salvas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: AntiqueWhite;
            padding: 20px;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: green;
        }

        .receita {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            max-height: 600px; /* Aumentei a altura máxima do frame */
            overflow-y: auto; /* Deixa a rolagem apenas se necessário */
        }

        .receita h3 {
            margin-top: 0;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-size: 14px;
            max-height: 250px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
            font-family: Courier, monospace;
        }

        .botoes {
            text-align: right;
            margin-top: 10px;
        }

        .botoes form {
            display: inline;
        }

        .botoes button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .voltar {
            text-align: center;
            margin-top: 30px;
        }

        .voltar a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>📜 Receitas Salvas</h1>

        <?php while($row = $result->fetch_assoc()): ?>
            <div class="receita">
                <h3><?= htmlspecialchars($row['tipo']) ?></h3>
                <strong>Ingredientes:</strong> <?= htmlspecialchars($row['ingredientes']) ?><br><br>
                <strong>Receita:</strong>
                <pre><?= htmlspecialchars($row['receita']) ?></pre>

                <div class="botoes">
                    <form action="excluir.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <div class="voltar">
            <a href="teste.php">⬅ Voltar para criar receita</a>
        </div>
    </div>
</body>
</html>