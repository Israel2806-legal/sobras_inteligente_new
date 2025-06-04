<?php
include 'config.php'; // Conectando ao banco de dados

// Consultando todos os usuários cadastrados
$sql = "SELECT id, nome, email, telefone FROM usuarios";
$result = $conn->query($sql);

// Verificando se existem registros
if ($result->num_rows > 0) {
    // Exibindo os dados em uma tabela HTML
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
            </tr>";
    
    // Loop para mostrar os dados de cada usuário
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["nome"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["telefone"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum usuário encontrado.";
}

// Fechando a conexão
$conn->close();
?>
