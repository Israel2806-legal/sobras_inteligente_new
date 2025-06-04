<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Crie sua receita</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background-color: AntiqueWhite;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: LightGreen;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            font-size: 24px;
            color: black;
            font-weight: bold;
            margin: 0;
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-frame {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
        }
        .form-frame label {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            display: block;
            margin-bottom: 10px;
        }
        .form-frame input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            height: 40px;
        }
        .form-frame button {
            background-color: #4caf50;
            color: white;
            font-size: 14px;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            height: 40px;
            width: 100%;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .form-frame .link-btn {
            background-color: LightGreen;
            color: black;
        }
    </style>
</head>
<body>

    <nav>
        <a href="index.php">Início</a> |
        <a href="cadastro.html">Cadastro</a> |
        <a href="login.php">Login</a> |
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <hr>
    

    <div class="header">
        <h1>Crie sua receita</h1>
    </div>

    <div class="container">
        <form class="form-frame" action="conexaoIA.php" method="post">
            <label for="ingredientes">Digite seus Ingredientes</label>
            <input type="text" id="ingredientes" name="ingredientes" placeholder="Ex: tomate, queijo, frango" required>
            <button type="submit" name="acao" value="restrito">Receita com só esses ingredientes</button>
            <button type="submit" name="acao" value="complementar">Receita com ingredientes extras</button>
            <button type="button" class="link-btn" onclick="window.location.href='receitas.php'">📜 Ver receitas salvas</button>
        </form>
    </div>

</body>
</html>