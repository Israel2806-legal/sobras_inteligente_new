<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    include("conexao.php");

    $stmt = $conn->prepare("DELETE FROM receitas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: receitas.php"); 
    exit();
} else {
    echo "ID inválido.";
}
?>